@extends('layouts.admin')
@push('title', get_phrase('Google Login Settings'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

    {{-- Page Header --}}
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Google Login Settings') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">

            {{-- Setup Guide --}}
            <div class="ol-card p-4 mb-4">
                <h5 class="title fs-14px mb-3">
                    <i class="fi-rr-info me-2 text-primary"></i>
                    {{ get_phrase('Google Cloud Console Setup Guide') }}
                </h5>
                <ol class="ps-3" style="line-height:2;">
                    <li>{{ get_phrase('Go to') }} <a href="https://console.cloud.google.com/" target="_blank" rel="noopener noreferrer">Google Cloud Console</a> {{ get_phrase('and create or select a project.') }}</li>
                    <li>{{ get_phrase('Navigate to') }} <strong>APIs & Services → OAuth consent screen</strong> {{ get_phrase('and configure it (User Type: External).') }}</li>
                    <li>{{ get_phrase('Go to') }} <strong>APIs & Services → Credentials</strong>, {{ get_phrase('click') }} <strong>Create Credentials → OAuth 2.0 Client IDs</strong>.</li>
                    <li>{{ get_phrase('Set Application type to') }} <strong>Web application</strong>.</li>
                    <li>{{ get_phrase('Under') }} <strong>Authorized redirect URIs</strong>, {{ get_phrase('add:') }}<br>
                        <code class="text-danger">{{ route('auth.google.callback') }}</code>
                    </li>
                    <li>{{ get_phrase('Copy the') }} <strong>Client ID</strong> {{ get_phrase('and') }} <strong>Client Secret</strong> {{ get_phrase('and paste them below.') }}</li>
                </ol>
            </div>

            {{-- Settings Form --}}
            <div class="ol-card p-4">
                <h3 class="title text-14px mb-3">{{ get_phrase('Google OAuth Configuration') }}</h3>
                <div class="ol-card-body">

                    @include('admin.toaster')

                    <form class="required-form" action="{{ route('admin.google.settings.update') }}" method="POST">
                        @csrf

                        {{-- Status --}}
                        <div class="fpb-7 mb-4">
                            <label class="form-label ol-form-label">
                                {{ get_phrase('Google Login Status') }}<span class="required text-danger ms-1">*</span>
                            </label><br>
                            <div class="d-flex gap-4 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="google_status_on"
                                           name="google_login_status" value="1"
                                           {{ get_settings('google_login_status') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="google_status_on">
                                        {{ get_phrase('Enabled') }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="google_status_off"
                                           name="google_login_status" value="0"
                                           {{ get_settings('google_login_status') != '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="google_status_off">
                                        {{ get_phrase('Disabled') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Client ID --}}
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="google_client_id">
                                {{ get_phrase('Google Client ID') }}<span class="text-danger ms-1">*</span>
                            </label>
                            <input type="text" id="google_client_id" name="google_client_id"
                                   class="form-control ol-form-control"
                                   placeholder="{{ get_phrase('Paste your Google Client ID here') }}"
                                   value="{{ get_settings('google_client_id') }}">
                        </div>

                        {{-- Client Secret --}}
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="google_client_secret">
                                {{ get_phrase('Google Client Secret') }}<span class="text-danger ms-1">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" id="google_client_secret" name="google_client_secret"
                                       class="form-control ol-form-control"
                                       placeholder="{{ get_phrase('Paste your Google Client Secret here') }}"
                                       value="{{ get_settings('google_client_secret') }}">
                                <button type="button" class="btn btn-outline-secondary" id="toggleSecret" title="{{ get_phrase('Show/Hide') }}">
                                    <i class="fi fi-rr-eye" id="secretEyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Redirect URI (read-only) --}}
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="google_redirect_uri">
                                {{ get_phrase('Authorized Redirect URI') }}
                                <span class="text-muted ms-1" style="font-size:12px;">({{ get_phrase('Auto-filled. Copy this to Google Console.') }})</span>
                            </label>
                            <div class="input-group">
                                <input type="text" id="google_redirect_uri" name="google_redirect_uri"
                                       class="form-control ol-form-control"
                                       value="{{ get_settings('google_redirect_uri') ?: route('auth.google.callback') }}"
                                       placeholder="{{ route('auth.google.callback') }}">
                                <button type="button" class="btn btn-outline-secondary" id="copyRedirectUri" title="{{ get_phrase('Copy') }}">
                                    <i class="fi fi-rr-copy-alt"></i>
                                </button>
                            </div>
                            <small class="text-muted mt-1 d-block">
                                {{ get_phrase('Default callback URL:') }}
                                <code>{{ route('auth.google.callback') }}</code>
                            </small>
                        </div>

                        <div class="fpb-7 mt-4">
                            <button type="submit" class="btn ol-btn-primary">
                                <i class="fi fi-rr-disk me-1"></i>
                                {{ get_phrase('Save Changes') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- Preview Card --}}
        <div class="col-xl-4">
            <div class="ol-card p-4">
                <h5 class="title fs-14px mb-3">{{ get_phrase('Login Button Preview') }}</h5>
                <p class="text-muted" style="font-size:13px;">{{ get_phrase('This is how the button will appear on the login page when enabled.') }}</p>
                <div class="mt-3">
                    <div class="text-center my-2">
                        <span class="text-muted" style="font-size:13px;">{{ get_phrase('or') }}</span>
                    </div>
                    <a href="javascript:void(0);"
                       class="btn w-100 d-flex align-items-center justify-content-center gap-2"
                       style="background:#fff;border:1.5px solid #ddd;color:#444;font-weight:500;padding:10px 16px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                        </svg>
                        {{ get_phrase('Continue with Google') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
<script>
"use strict";

// Toggle client secret visibility
document.getElementById('toggleSecret').addEventListener('click', function () {
    var input = document.getElementById('google_client_secret');
    var icon  = document.getElementById('secretEyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fi fi-rr-eye-crossed';
    } else {
        input.type = 'password';
        icon.className = 'fi fi-rr-eye';
    }
});

// Copy redirect URI to clipboard
document.getElementById('copyRedirectUri').addEventListener('click', function () {
    var uriInput = document.getElementById('google_redirect_uri');
    navigator.clipboard.writeText(uriInput.value).then(function () {
        var btn = document.getElementById('copyRedirectUri');
        btn.innerHTML = '<i class="fi fi-rr-check"></i>';
        setTimeout(function () {
            btn.innerHTML = '<i class="fi fi-rr-copy-alt"></i>';
        }, 2000);
    });
});
</script>
@endpush
