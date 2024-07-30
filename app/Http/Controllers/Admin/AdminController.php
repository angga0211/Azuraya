<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\newProdukJob;
use App\Jobs\notifPesananJob;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\ProdukKategori;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard(){
        $dataUser = User::where('level', 'pengguna')->count();
        $dataPesanan = Pesanan::count();
        $pendapatan = Pesanan::where('bayar', 'Sudah dibayar')->sum('subtotal');

        return view('admin.dashboard', [
            'judul' => 'Dashboard',
            'dataUser'=>$dataUser, 
            'dataPesanan'=>$dataPesanan, 
            'pendapatan'=>$pendapatan, 
        ]);
    }

    public function kategori(){
        $dataKategori = ProdukKategori::withCount('produk')
            ->orderBy('nama', 'ASC')
            ->paginate(10);

        return view('admin.kategori.index', [
            'judul' => 'Kategori',
            'dataKategori'=>$dataKategori
        ]);
    }
    public function tambahKategori(){
        return view('admin.kategori.create', [
            'judul' => 'Kategori',
        ]);
    }

    public function simpanKategoriBaru(Request $request){
        $request->validate([
            'nama' => 'required|unique:produk_kategoris', 
            'slug' => 'required|unique:produk_kategoris',
        ], [
            'nama.unique' => 'Kategori produk sudah ada.', 
            'slug.unique' => 'Slug produk sudah ada.',
        ]); 
        $kategori = new ProdukKategori();
        $kategori->nama = $request->input('nama');
        $kategori->slug = $request->input('slug');
        $kategori->save();
        return redirect('/admin/produk-kategori')->with('success','Kategori berhasil di tambahkan');
    }

    public function hapusKategori($slug){
        $produkKategori = ProdukKategori::where('slug', $slug)->first();
        if($produkKategori != null){
            try{
                $produkKategori->delete();
                return back()->with('success', 'Kategori produk berhasil dihapus');
            }catch(Exception $e){
                return back()->with('error', "Kategori produk tidak bisa dihapus");
            }
        }
        return back()->with('error', 'Kategori produk tidak ditemukan');
    }
    public function editKategori($slug){
        $produkKategori = ProdukKategori::where('slug', $slug)->first();
        if($produkKategori != null){
            return view('admin.kategori.edit', [
                'judul' => 'Kategori',
                'produkKategori'=>$produkKategori
            ]);
        }
        return back()->with('error', 'Kategori produk tidak ditemukan');
    }
    public function updateKategoriBaru(Request $request){
        $id = $request->input('id');
        $validatedData = $request->validate([
            'nama' => 'required|unique:produk_kategoris,nama,' . $id,
            'slug' => 'required|unique:produk_kategoris,slug,' . $id
        ]);
        ProdukKategori::find($id)->update($validatedData);
        return redirect('/admin/produk-kategori')->with('success', 'Kategori produk berhasil diupdate');
    }

    public function produk(){
        $dataProduk = Produk::with('produkkategori')
            ->orderBy('nama', 'ASC')
            ->paginate(10);

        return view('admin.produk.index', [
            'judul' => 'Produk',
            'dataProduk'=>$dataProduk
        ]);
    }
    public function tambahProduk(){
        return view('admin.produk.create', [
            'judul' => 'Produk',
            'dataKategori' => ProdukKategori::all() 
        ]);
    }

    public function simpanProduk(Request $request){
        $request->validate([
            'nama' => 'required|string|unique:produks',
            'slug' => 'required|string|unique:produks',
            'deskripsi' => 'required|string',
            'stok' => 'required',
            'berat' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'kategori_id' => 'required',
        ]);

        $produk = new Produk();
        if ($request->file('image')) {
            Storage::delete('public/' . $produk->image);
            $imagePath = $request->file('image')->store('public/produk');
            $image = str_replace('public/', '', $imagePath);
            $produk->image = $image;
        }
        $produk->nama = $request->nama;
        $produk->slug = $request->slug;
        $produk->deskripsi = $request->deskripsi;
        $produk->stok = $request->stok;
        $produk->berat = $request->berat;
        $produk->kategori_id = $request->kategori_id;
        $produk->harga = $request->harga;
        $produk->diskon = $request->diskon;
        $produk->hargaTotal = (int) $request->harga - ((int) $request->harga * $request->diskon / 100);
        $produk->save();
        dispatch(new newProdukJob($request->slug));
        return redirect('/admin/produk')->with('success', 'Produk baru berhasil ditambahkan');
    }

    public function hapusProduk($slug){
        $produk = Produk::where('slug', $slug)->first();
        if($produk != null){
            try{
                Storage::delete('public/' . $produk->image);
                $produk->delete();
                return back()->with('success', 'Produk berhasil dihapus');
            }catch(Exception $e){
                return back()->with('error', "Produk tidak bisa dihapus");
            }
        }
        return back()->with('error', 'Produk tidak ditemukan');
    }
    public function editProduk($slug){
        $dataProduk = Produk::where('slug', $slug)->first();
        if($dataProduk != null){
            return view('admin.produk.edit', [
                'judul' => 'Produk',
                'dataProduk'=>$dataProduk,
                'dataKategori' => ProdukKategori::all() 
            ]);
        }
        return back()->with('error', 'Produk tidak ditemukan');
    }

    public function updateProduk(Request $request){
        $id = $request->input('id');
        $request->validate([
            'nama' => 'required|string|unique:produks,nama,'.$id,
            'slug' => 'required|string|unique:produks,nama,'.$id,
            'deskripsi' => 'required|string',
            'stok' => 'required',
            'berat' => 'required',
            'harga' => 'required',
            'diskon' => 'required',
            'kategori_id' => 'required',
        ]);
        $produk = Produk::where('id',$id)->first();
        if ($request->file('image')) {
            Storage::delete('public/' . $produk->image);
            $imagePath = $request->file('image')->store('public/produk');
            $image = str_replace('public/', '', $imagePath);
            $produk->image = $image;
        }
        $produk->nama = $request->nama;
        $produk->slug = $request->slug;
        $produk->deskripsi = $request->deskripsi;
        $produk->stok = $request->stok;
        $produk->berat = $request->berat;
        $produk->kategori_id = $request->kategori_id;
        $produk->harga = $request->harga;
        $produk->diskon = $request->diskon;
        $produk->hargaTotal = (int) $request->harga -((int) $request->harga * $request->diskon / 100);
        $produk->save();
        return redirect('/admin/produk')->with('success', 'Produk baru berhasil diupdate');
    }
    public function pesanan(Request $request){
        $jumlahPesanan = [
            'semua' => Pesanan::all()->count(),
            'baru' => Pesanan::where('status', 'Pesanan Baru')->count(),
            'siap' => Pesanan::where('status', 'Siap Dikirim')->count(),
            'kirim' => Pesanan::where('status', 'Dalam Pengiriman')->count(),
            'selesai' => Pesanan::where('status', 'Pesanan Selesai')->count(),
            'batal' => Pesanan::where('status', 'Pesanan Dibatalkan')->count(),
        ];
        $currentStatus = $request->query('status', 'Semua Pesanan');
        return view('admin.pesanan.list', [
            'judul'=> 'Pesanan',
            'dataPesanan'=> Pesanan::orderBy('updated_at', 'DESC')
                ->filter(request()->all())
                ->paginate(5),
            'jumlahPesanan'=>$jumlahPesanan,
            'currentStatus' => $currentStatus
        ]);
    }

    public function detailPesanan($invoice){
        $pesanan = Pesanan::where('invoice', $invoice)
            ->with('pesanan_detail')
            ->first();
        if($pesanan != null){
            return view('admin.pesanan.show', [
                'judul'=> 'Pesanan',
                'dataPesanan'=> $pesanan
            ]);
        }
        return back()->with('error', 'Transaksi tidak ditemukan');
    }
    public function batalkanPesanan($invoice){
        $pesanan = Pesanan::where('invoice', $invoice)
            ->first();
        if($pesanan != null){
            $pesanan->status = "Pesanan Dibatalkan";
            $pesanan->save();
            $user = Auth::user();
            $admin = User::where('level','admin')->first();
            dispatch(new notifPesananJob('Dibatalkan', $user->nama,"", $pesanan->invoice, now(), $pesanan->alamat_pengiriman, $admin->email, $admin->level));
            dispatch(new notifPesananJob('Dibatalkan', $user->nama,"", $pesanan->invoice, now(), $pesanan->alamat_pengiriman, $user->email, $user->level));
            return back()->with('success', 'Transaksi berhasil dibatalkan');
        }
        return back()->with('error', 'Transaksi tidak ditemukan');
    }
    public function tambahNoResi(Request $request,$invoice){
        $pesanan = Pesanan::where('invoice', $invoice)
            ->first();
        if($pesanan != null){
            $request->validate([
                'nomor_resi' => 'required',
            ]);
            $pesanan->status = "Dalam Pengiriman";
            $pesanan->nomor_resi = $request->nomor_resi;
            $pesanan->save();
            return back()->with('success', 'Nomor resi berhasil ditambahkan');
        }
        return back()->with('error', 'Transaksi tidak ditemukan');
    }

    public function selesaikanPesanan($invoice){
        $pesanan = Pesanan::where('invoice', $invoice)
            ->first();
        if($pesanan != null){
            $pesanan->status = "Pesanan Selesai";
            $pesanan->save();
            $user = Auth::user();
            $admin = User::where('level','admin')->first();
            dispatch(new notifPesananJob('Telah Selesai', $user->nama,"", $pesanan->invoice, now(), $pesanan->alamat_pengiriman, $admin->email, $admin->level));
            dispatch(new notifPesananJob('Telah Selesai', $user->nama,"", $pesanan->invoice, now(), $pesanan->alamat_pengiriman, $user->email, $user->level));
            return back()->with('success', 'Transaksi berhasil diselesaikan');
        }
        return back()->with('error', 'Transaksi tidak ditemukan');
    }

    public function profilAdmin(){
        return view('admin.profile', [
            'judul' => 'Profile',
            'dataUser' => Auth::user()
        ]);
    }
    public function profilAdminUpdate(Request $request){
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
        return redirect('/admin/profil')->with('success', 'Profil updated successfully');
    }
}
