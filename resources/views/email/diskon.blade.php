@extends('email.index')
@section('konten')
<div class="container">
    <div>
        <h1>Produk Kami Diskon {{ $diskon }}%</h1>
        <p>hai {{ $nama }} ada diskon ni buat kamu</p>
    </div>
    <span></span>
    <p>Produk {{ $produk }} kami saat ini diskon loh</p>
    <p>Dari <s>Rp.{{ number_format($harga, 0, ',', '.')}}</s> menjadi Rp.{{ number_format($hargaTotal, 0, ',', '.')}}</p>
</div>
@endsection
