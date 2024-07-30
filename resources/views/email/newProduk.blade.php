@extends('email.index')
@section('konten')
    <div class="container">
        <div>
            <h1>Produk Baru</h1>
            <p>Hai {{ $nama }}</p>
        </div>
        <span></span>
        <p>Kami memiliki produk baru nih buat kamu</p>
        <p>{{ $namaProduk }} tersedia hanya Rp.{{ number_format($harga, 0, ',', '.')}} buat kamu</p>
    </div>
@endsection
