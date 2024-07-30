@extends('email.index')
@section('konten')
<div class="container">
    <div>
        <h1>Verivikasi OTP</h1>
        <p></p>
    </div>
    <span></span>
    <p>Kode OTP kamu adalah</p>
    <h3 class="otp">{{ $no_otp }}</h3>
    <p>Kode OTP kamu akan kadarluarsa dalam 5 menit</p>
</div>
@endsection
