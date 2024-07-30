@extends('email.index')
@section('konten')
<div class="container">
    <div>
        <h1>Pesanan {{ $status }}</h1>
    </div>
    <span></span>
    <table>
        <tbody>
            <td>No. Pesanan</td>
            <td>: {{ $invoice }}</td>
        </tbody>
        <tbody>
            <td>Nama</td>
            <td>: {{ $nama }}</td>
        </tbody>
        <tbody>
            <td>Tanggal Pesan</td>
            <td>: {{ $waktuPesan }}</td>
        </tbody>
        <tbody>
            <td>Alamat Pengiriman</td>
            <td>: {{ $alamat }}</td>
        </tbody>
    </table>
</div>
@endsection
