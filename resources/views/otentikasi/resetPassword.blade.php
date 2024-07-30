@extends('user.index')
@section('konten')
<main class="content">
    <div class="page-width my-2"><span><a href="/" class="text-interactive">Home</a><span> /
            </span></span><span>Reset Password</span></div>
    <div class="flex justify-center items-center">
        <div class="login-form flex justify-center items-center">
            <div class="login-form-inner">
                <h1 class="text-center">Reset Password</h1>
                <form id="loginForm"  action="/reset-password" method="POST">
                    @csrf
                    <div class="">
                        <div class="form-field-container null">
                            <div class="field-wrapper flex flex-grow"><input type="text" name="email" placeholder="Email" value="{{ $email }}" readonly/>
                                <div class="field-border"></div>
                            </div>
                        </div>
                        <div class="form-field-container null">
                            <div class="field-wrapper flex flex-grow"><input type="password" name="password"
                                    placeholder="Password" value="" />
                                <div class="field-border"></div>
                            </div>
                        </div>
                        <div class="form-field-container null">
                            <div class="field-wrapper flex flex-grow"><input type="password" name="password_confirmation"
                                    placeholder="Ulangi Password" value="" />
                                <div class="field-border"></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-submit-button flex border-t border-divider mt-1 pt-1"><button type="submit"
                            class="button primary"><span>Update Password</span></button></div>
                </form>
                <div class="text-center mt-1 flex justify-center">Ingin Login?<a class="text-interactive"
                        href="/login"> Login</a></div>
            </div>
        </div>
    </div>
</main>
@endsection
