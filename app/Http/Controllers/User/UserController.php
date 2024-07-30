<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\notifPesananJob;
use App\Models\Keranjang;
use App\Models\Kota;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use App\Models\Produk;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function keranjangList($username){
        if ($username!==auth()->user()->username) {
            return redirect('/keranjang/'.auth()->user()->username);
        }
        
        return view('user.keranjang', [
            'judul' => 'Keranjang',
            
            'dataKeranjang' => Keranjang::orderBy('updated_at', 'desc')
                ->with('produk')
                ->where('user_id', auth()->user()->id)
                ->paginate(10)
        ]);
    }
    public function tambahKeKeranjang(Request $request){
        $user_id = auth()->user()->id;
        $produk_id = $request->input('produk_id');
        $quantity = $request->input('quantity');

        $produk = Produk::find($produk_id);
        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }
        if ($produk->stok < $quantity) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }
        $existingItem = Keranjang::where('user_id', $user_id)
            ->where('produk_id', $produk_id)
            ->first();
        if ($existingItem) {
            if ($produk->stok < ($existingItem->quantity + $quantity)) {
                return back()->with('error', 'Stok produk tidak mencukupi.');
            }
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            $datas = [
                'user_id' => $user_id,
                'produk_id' => $produk_id,
                'quantity' => $quantity,
            ];
            Keranjang::create($datas);
        }
        return back()->with('success', 'Produk berhasil ditambahkan');
    }
    public function hapusKeranjang(Request $request){
        $user_id = auth()->user()->id;
        $keranjang_id = $request->input('keranjang_id');
        $keranjangItem = Keranjang::where('user_id', $user_id)
            ->where('id', $keranjang_id)
            ->first();
        if ($keranjangItem) {
            $keranjangItem->delete();
            return back()->with('success', 'Produk berhasil dihapus dari keranjang');   
        }else{
            return back()->with('error', 'Produk tidak ditemukan di keranjang');
        }
    }
    public function Checkout($username,Request $request){
        $request->session()->put('checkout_in_progress', true);
        if ($username!==auth()->user()->username) {
            return back();
        }
        return view('user.pembayaran', [
            'judul' => 'Pembayaran',
            
            'daftarProvinsi' => Provinsi::all(),
            'daftarKota' => Kota::all(),
            'dataKeranjang' => Keranjang::orderBy('updated_at', 'desc')
                ->with('produk', 'user')
                ->where('user_id', auth()->user()->id)
                ->get()
        ]);
    }

    public function fetchShippingMethods(Request $request)
    {
        $provinsiId = $request->input('provinsi');
        $kotaId = $request->input('kota');
        $weight = $request->input('weight', 1000);
        $origin = 365;
        try {
            $shippingMethods = RajaOngkir::ongkosKirim([
                'origin' => $origin,
                'destination' => $kotaId,
                'weight' => $weight,
                'courier' => 'jne'
            ])->get();
            return response()->json($shippingMethods);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch shipping methods'], 500);
        }
    }
    public function ProsesCheckout($username, Request $request){
        if ($username!==auth()->user()->username) {
            return back();
        }
        $dataKeranjang = Keranjang::where('user_id', auth()->user()->id)
            ->with('produk')
            ->get();
        $invoice = $this->buatNoPesanan();
        $subtotal = 0;
        $discountTotal = 0;
        foreach ($dataKeranjang as $item) {
            $subtotal += $item->produk->harga * $item->quantity;
            $discountTotal += ($item->produk->harga - $item->produk->hargaTotal) * $item->quantity;
        }
        $grandTotal = $subtotal - $discountTotal;
        $validated = $request->validate([
            'detail_alamat' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kode_pos' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'nama_pemesan' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'catatan' => 'nullable|string|max:500',
            'ongkir' => 'required|numeric',
            'layanan' => 'required|string|max:255',
        ]);
        
        $alamat_pengiriman = $validated['detail_alamat'] . ", Kecamatan " . $validated['kecamatan'] . ", Kota " . $validated['kota'] . ", Provinsi " . $validated['provinsi'] . ", Kode Pos " . $validated['kode_pos'];
        $pesanan = Pesanan::create([
            'invoice' => $invoice,
            'email' => $validated['email'],
            'nama_pemesan' => $validated['nama_pemesan'],
            'telepon' => $validated['telepon'],
            'catatan' => Arr::get($validated, 'catatan', null),
            'alamat_pengiriman' => $alamat_pengiriman,
            'user_id' => auth()->user()->id,
            'total' => $grandTotal,
            'ongkir' => $validated['ongkir'],
            'subtotal' => $grandTotal+$validated['ongkir'],
            'layanan' => $validated['layanan']
        ]);

        foreach ($dataKeranjang as $item) {
            PesananDetail::create([
                'pesanan_id' => $pesanan->id,
                'image_produk' => $item->produk->image,
                'nama_produk' => $item->produk->nama,
                'banyak_dibeli' => $item->quantity,
                'harga' => $item->produk->hargaTotal,
                'hargaTotal' => $item->produk->hargaTotal * $item->quantity,
            ]);
            $produk = Produk::where('id',$item->produk_id)->first();
            if ($produk) {
                $produk->stok -= $item->quantity;
                $produk->save();
            }
        }
        $user = Auth::user();
        $admin = User::where('level','admin')->first();
        dispatch(new notifPesananJob('Masuk', $user->nama,"", $invoice, now(), $alamat_pengiriman, $admin->email, $admin->level));
        dispatch(new notifPesananJob('Dibuat', $user->nama,"", $invoice, now(), $alamat_pengiriman, $user->email, $user->level));

        Keranjang::where('user_id', auth()->user()->id)->delete();
       
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $grandTotal+$validated['ongkir'],
            ),
            'customer_details' => array(
                'first_name' => $validated['nama_pemesan'],
                'email' => $validated['email'],
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $pesanan->snap_token = $snapToken;
        $pesanan->save();

        return redirect('/proses-pembayaran/'.$invoice)->with('success', 'Pesanan berhasil dibuat');
    }
    function buatNoPesanan() {
        $last_record = Pesanan::whereDate('created_at', Carbon::today())->latest()->first();
        if($last_record!=null){
            $next_id = $last_record->id+1;
        }else{
            $next_id = 1;
        }
        $date = Carbon::today()->format('dmy');
        return 'INV-'.$date.'-'.$next_id;
    }
    public function Profil(){
        return view('user.profil', [
            'judul' => 'Profil',
            'dataUser' => auth()->user(),
            'dataKeranjang' => $this->getDataKeranjang(),
        ]);
    }

    public function updateProfile(Request $request){
        $user = User::findOrFail(auth()->id());
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username,' . $user->id
            ],
            'jenis_kelamin' => 'required|in:Perempuan,Laki-Laki',
            'telepon' => [
                'required',
                'string',
                'max:20',
                'unique:users,telepon,' . $user->id
            ],
            'password' => 'nullable|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();
        if ($request->file('image')) {
            Storage::delete('public/' . $user->image);
            $imagePath = $request->file('image')->store('public/profil-user');
            $validatedData['image'] = str_replace('public/', '', $imagePath);
        }

        $user->update([
            'nama' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'telepon' => $validatedData['telepon'],
            'image' => $validatedData['image'] ?? $user->image,
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
        ]);  
        return redirect('/profil/'.$user->username)->with('success', 'Profil updated successfully');
    }

    public function getDataKeranjang()
    {
        $dataKeranjang = collect();
        
        if (Auth::check()) {
            $dataKeranjang = Keranjang::orderBy('updated_at', 'desc')
                ->where('user_id', auth()->user()->id)
                ->get();
        }
        
        return $dataKeranjang;
    }
    public function riwayatPesanan($username){
        if ($username!==auth()->user()->username) {
            return back();
        }
        return view('user.riwayatPesanan', [
            'judul' => 'Riwayat Pesanan',
            'dataKeranjang' => $this->getDataKeranjang(),
            'dataUser' => auth()->user(),
            'dataPesanan' => Pesanan::where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'desc')
                ->filter(request()->all())
                ->with('pesanan_detail')
                ->paginate(5),
        ]);
    }
    public function detailPesanan($username, $invoice){
        if ($username!==auth()->user()->username) {
            return back();
        }
        $pesanan = Pesanan::where('invoice', $invoice)
            ->with('pesanan_detail')
            ->first();

        return view('user.detailPesanan', [
            'judul' => 'Riwayat Pesanan',
            'dataKeranjang' => $this->getDataKeranjang(),
            'dataPesanan' => $pesanan,
        ]);
    }
    public function batalPesan(Request $request){
        $pesanan = Pesanan::where('id', $request->input('id'))->first();
        if (!$pesanan) {
            return back()->with('error', 'Pesanan tidak ditemukan');
        }

        $pesananDetails = PesananDetail::where('pesanan_id', $pesanan->id)->get();
        foreach ($pesananDetails as $detail) {
            $produk = Produk::where('nama', $detail->nama_produk)->first();
            if ($produk) {
                $produk->stok += $detail->banyak_dibeli;
                $produk->save();
            }
        }
        $pesanan->status = 'Pesanan Dibatalkan';
        $pesanan->save();
        $user = Auth::user();
        $admin = User::where('level','admin')->first();
        dispatch(new notifPesananJob('Dibatalkan', $user->nama,"", $pesanan->invoice, now(), $pesanan->alamat_pengiriman, $admin->email, $admin->level));
        dispatch(new notifPesananJob('Dibatalkan', $user->nama,"", $pesanan->invoice, now(), $pesanan->alamat_pengiriman, $user->email, $user->level));
        return back()->with('success', 'Pesanan berhasil dibatalkan');
    }
    public function terimaPesanan(Request $request){
        $pesanan = Pesanan::where('id', $request->input('id'))->first();
        if (!$pesanan) {
            return back()->with('error', 'Pesanan tidak ditemukan');
        }
        $pesanan->status = 'Pesanan Selesai';
        $pesanan->save();
        $user = Auth::user();
        $admin = User::where('level','admin')->first();
        dispatch(new notifPesananJob('Telah Selesai', $user->nama,"", $pesanan->invoice, now(), $pesanan->alamat_pengiriman, $admin->email, $admin->level));
        dispatch(new notifPesananJob('Telah Selesai', $user->nama,"", $pesanan->invoice, now(), $pesanan->alamat_pengiriman, $user->email, $user->level));
        return back()->with('success', 'Pesanan berhasil diselesaikan');
    }
    public function pembayaran($invoice){
        $pesanan = Pesanan::where('invoice', $invoice)->first();
        if (!$pesanan) {
            return back()->with('error', 'Pesanan tidak ditemukan');
        }
        return view('user.bayarTransaksi', [
            'judul' => 'Pembayaran',
            'dataKeranjang' => $this->getDataKeranjang(),
            'dataPesanan' => $pesanan,
        ]);
    }

    public function bayarBerhasil($username, $invoice){
        $pesanan = Pesanan::where('invoice', $invoice)->first();
        if (!$pesanan) {
            return back();
        }
        if ($username!==auth()->user()->username) {
            return back();
        }
        $pesanan->bayar = 'Sudah dibayar';
        $pesanan->status = 'Siap Dikirim';
        $pesanan->save();
        return redirect('/detail-pesanan/'.$username.'/'.$pesanan->invoice)->with('success', 'Pembayaran berhasil dilakukan');
    }
}
