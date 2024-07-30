@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2"><span><a href="/" class="text-interactive">Home</a><span> /
            </span></span><span>Login</span></div>
    <div class="flex justify-center items-center">
        <div class="login-form flex justify-center items-center">
            <div class="login-form-inner">
                <h1 class="text-center speakable">Login</h1>
                <form id="loginForm" action="/login" method="POST">
                    @csrf
                    <div class="">
                        <div class="form-field-container null">
                            <div class="field-wrapper flex flex-grow"><input type="text" required name="username"
                                    placeholder="Username" value="{{old('username')}}" />
                                <div class="field-border"></div>
                            </div>
                        </div>
                        <div class="form-field-container null">
                            <div class="field-wrapper flex flex-grow"><input required type="password" name="password"
                                    placeholder="Password" value="" />
                                <div class="field-border"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-submit-button flex border-t border-divider mt-1 pt-1"><button type="submit"
                            class="button primary speakable"><span>SIGN IN</span></button></div>
                </form>
                <div class="text-center mt-1 gap-2 flex justify-center"><a class="speakable text-interactive"
                        href="/register">Buat akun baru?</a><a class="speakable" href="/lupa-password">Lupa Password?</a></div>
            </div>
        </div>
    </div>
</main>
@endsection
