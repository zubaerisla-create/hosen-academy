@extends('layouts' . '.' . get_frontend_settings('theme'))
@push('title', get_phrase('Log In'))
@push('meta')@endpush
@push('css')
    <style>
        .form-icons .right {
            right: 20px;
            cursor: pointer !important;
        }
    </style>
@endpush
@section('content')
    @if (get_frontend_settings('theme') == 'default')
        <!------------------- Login Area Start  ------>
        <section class="login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <div class="login-img">
                            <img src="{{ asset('assets/frontend/default/image/login.gif') }}" alt="...">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <form action="{{ route('login') }}" class="global-form login-form mt-25" id="login-form" method="POST">
                            @csrf
                            <h4 class="g-title">{{ get_phrase('Login') }}</h4>
                            <p class="description">{{ get_phrase('See your growth and get consulting support!') }} </p>
                             <input type="hidden" id="user_agent" name="user_agent"  >
                            <div class="form-group">
                                <label for="email" class="form-label">{{ get_phrase('Email') }}</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="{{ get_phrase('Your Email') }}">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">{{ get_phrase('Password') }}</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="*********">
                            </div>
                            <div class="form-group mb-25 d-flex justify-content-between align-items-center remember-me">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                    <label class="form-check-label" for="flexCheckChecked">{{ get_phrase('Remember Me') }}</label>
                                </div>
                                <a href="{{route('password.request')}}">{{ get_phrase('Forget Password?') }}</a>
                            </div>

                            @if(get_frontend_settings('recaptcha_status'))
                                <button class="eBtn gradient w-100 g-recaptcha" data-sitekey="{{ get_frontend_settings('recaptcha_sitekey') }}" data-callback='onLoginSubmit' data-action='submit'>{{ get_phrase('Login') }}</button>
                            @else
                                <button type="submit" class="eBtn gradient w-100">{{ get_phrase('Login') }}</button>
                            @endif

                            <p class="mt-20">{{ get_phrase('Not have an account yet?') }}
                                <a href="{{ route('register.form') }}">{{ get_phrase('Create Account') }}</a>
                            </p>

                            @if(get_settings('google_login_status') == '1')
                            <div class="text-center my-3">
                                <span class="text-muted" style="font-size:13px;">{{ get_phrase('or') }}</span>
                            </div>
                            <a href="{{ route('auth.google') }}" class="eBtn w-100 d-flex align-items-center justify-content-center gap-2" style="background:#fff;border:1.5px solid #ddd;color:#444;font-weight:500;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                </svg>
                                {{ get_phrase('Continue with Google') }}
                            </a>
                            @endif

                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!------------------- Login Area End  ------>
    @endif
@endsection
@push('js')

    <script>
        "use strict";

        $(document).ready(function() {
            $('.custom-btn').on('click', function(e) {
                e.preventDefault();

                var role = $(this).attr('id');
                if (role == 'admin') {
                    $('#email').val('admin@example.com');
                    $('#password').val('12345678');
                } else if (role == 'student') {
                    $('#email').val('student@example.com');
                    $('#password').val('12345678');
                } else {
                    $('#email').val('instructor@example.com');
                    $('#password').val('12345678');
                }
                $('#login').trigger('click');
            });
        });

        $(document).ready(function() {
            $('#showpassword').on('click', function(e) {
                e.preventDefault();
                const type = $('#password').attr('type');

                if (type == 'password') {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
        });

        function onLoginSubmit(token) {
            document.getElementById("login-form").submit();
        }

    </script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Check if the device token already exists
        if (!localStorage.getItem('device_token')) {
            localStorage.setItem('device_token', crypto.randomUUID());
        }
        const deviceToken = localStorage.getItem('device_token');
        document.getElementById('user_agent').value = deviceToken;
    });
</script>



@endpush
