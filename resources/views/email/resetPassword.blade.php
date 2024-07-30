@extends('email.index')
@section('konten')
<div class="container">
    <div>
        <h1>Reset Password</h1>
    </div>
    <span></span>
    <p>Hai {{ $nama }}, Kami mendeteksi permintaan reset password untuk akun Anda. Silakan klik link di bawah untuk mereset password Anda:</p>
    <a href="{{ url('/reset-password?token='.$token.'&email='.$email) }}">Reset Password</a>
</div>
@endsection
