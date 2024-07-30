<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\ProdukKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        return view('user.home', [
            'judul' => 'AZURAYA',
            'dataKeranjang' => $this->getDataKeranjang(),
            'banyakDibeli' => Produk::select('image', 'nama', 'slug', 'harga', 'hargaTotal')
                ->orderBy('dibeli', 'desc')
                ->take(4)
                ->get(),
            'produkBaru' => Produk::select('image', 'nama', 'slug', 'harga', 'hargaTotal')
                ->orderBy('updated_at', 'desc')
                ->take(4)
                ->get(),
        ]);
    }

    public function produk()
    {
        return view('user.produk.produk', [
            'judul' => 'AZURAYA',
            'dataKeranjang' => $this->getDataKeranjang(),
            'dataProduk' => Produk::select('image', 'nama', 'slug', 'harga', 'hargaTotal')
                ->filter(request(['search','kategori']))
                ->orderBy('dibeli', 'desc')
                ->orderBy('updated_at', 'desc')
                ->paginate(12)
                ->withQueryString(),
            'dataKategori' =>ProdukKategori::all()
        ]);
    }

    public function show(Produk $produk, Request $request)
    {
        return view('user.produk.produkDetail',[
            'judul' => 'AZURAYA',
            'dataKeranjang' => $this->getDataKeranjang(),
            'dataProduk' => $produk,
        ]);
    }

    public function tentang()
    {
        return view('user.tentang', [
            'judul' => 'Tentang Azuraya',
            'dataKeranjang' => $this->getDataKeranjang(),
        ]);
        
    }
    public function hubungi()
    {
        return view('user.hubungi', [
            'judul' => 'Hubungi',
            'dataKeranjang' => $this->getDataKeranjang(),
        ]);
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
}
