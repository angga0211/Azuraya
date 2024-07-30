@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2"><span><a href="/" class="text-interactive speakable">Home</a><span> /
            </span></span><span class="speakable">Lupa Password</span></div>
    <div class="flex justify-center items-center">
        <div class="login-form flex justify-center items-center">
            <div class="login-form-inner">
                <h1 class="text-center speakable">{{ __('Reset Password') }}</h1>
                <form id="loginForm" action="/lupa-password" method="POST">
                    @csrf
                    <div class="">
                        <div class="form-field-container null">
                            <div class="field-wrapper flex flex-grow"><input type="text" name="email" required value="{{ old('email') }}" required autocomplete="email" />
                                <div class="field-border"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-submit-button flex border-t border-divider mt-1 pt-1"><button type="submit"
                            class="button primary"><span class="speakable"> {{ __('Send Password Reset Link') }}</span></button></div>
                </form>
                <div class="text-center mt-1 gap-2 flex justify-center"><a class="text-interactive speakable"
                        href="/login">Ingin kembali login?</a></div>
            </div>
        </div>
    </div>
</main>
@endsection
