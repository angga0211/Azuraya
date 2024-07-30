@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2"><span><a href="/" class="text-interactive">Home</a><span> /
            </span></span><span>Resgiter</span></div>
    <div class="flex justify-center items-center">
        <div class="login-form flex justify-center items-center">
            <div class="login-form-inner">
                <h1 class="text-center speakable">Resgister</h1>
                <form id="loginForm" action="/register" method="POST">
                    @csrf
                    <div class="">
                        <div class="form-field-container {{ $errors->has('nama') ? 'invalid' : '' }}">
                            <div class="field-wrapper flex flex-grow">
                                <input type="text" name="nama" placeholder="Nama" value="{{ old('nama') }}" />
                                <div class="field-border"></div>
                            </div>
                            @if ($errors->has('nama'))
                            <div class="invalid-message">{{ $errors->first('nama') }}</div>
                            @endif
                        </div>

                        <div class="form-field-container {{ $errors->has('username') ? 'invalid' : '' }}">
                            <div class="field-wrapper flex flex-grow">
                                <input type="text" name="username" placeholder="Username"
                                    value="{{ old('username') }}" />
                                <div class="field-border"></div>
                            </div>
                            @if ($errors->has('username'))
                            <div class="invalid-message">{{ $errors->first('username') }}</div>
                            @endif
                        </div>

                        <div class="form-field-container {{ $errors->has('telepon') ? 'invalid' : '' }}">
                            <div class="field-wrapper flex flex-grow">
                                <input type="text" name="telepon" placeholder="Telepon" value="{{ old('telepon') }}" />
                                <div class="field-border"></div>
                            </div>
                            @if ($errors->has('telepon'))
                            <div class="invalid-message">{{ $errors->first('telepon') }}</div>
                            @endif
                        </div>

                        <div class="form-field-container {{ $errors->has('email') ? 'invalid' : '' }}">
                            <div class="field-wrapper flex flex-grow">
                                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" />
                                <div class="field-border"></div>
                            </div>
                            @if ($errors->has('email'))
                            <div class="invalid-message">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="form-field-container {{ $errors->has('password') ? 'invalid' : '' }}">
                            <div class="field-wrapper flex flex-grow">
                                <input type="password" name="password" placeholder="Password" />
                                <div class="field-border"></div>
                            </div>
                            @if ($errors->has('password'))
                            <div class="invalid-message">{{ $errors->first('password') }}</div>
                            @endif
                        </div>

                        <div class="form-field-container {{ $errors->has('password') ? 'invalid' : '' }}">
                            <div class="field-wrapper flex flex-grow">
                                <input type="password" name="password_confirmation" placeholder="Ulangi Password" />
                                <div class="field-border"></div>
                            </div>
                            @if ($errors->has('password'))
                            <div class="invalid-message">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-submit-button flex border-t border-divider mt-1 pt-1"><button type="submit"
                            class="button primary speakable"><span>SIGN UP</span></button></div>
                </form>
                <div class="text-center mt-1 flex justify-center speakable">Sudah punya akun?<a class="text-interactive"
                        href="/login"> Login</a></div>
            </div>
        </div>
    </div>
</main>
@endsection
