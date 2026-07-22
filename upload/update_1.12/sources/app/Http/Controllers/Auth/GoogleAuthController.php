<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    private function configure(): void
    {
        $clientId     = get_settings('google_client_id');
        $clientSecret = get_settings('google_client_secret');
        $redirectUri  = get_settings('google_redirect_uri') ?: route('auth.google.callback');

        if (empty($clientId) || empty($clientSecret)) {
            abort(503, get_phrase('Google login is not configured. Please contact the administrator.'));
        }

        config([
            'services.google' => [
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'redirect'      => $redirectUri,
            ],
        ]);
    }

    public function redirect()
    {
        if (get_settings('google_login_status') != '1') {
            Session::flash('error', get_phrase('Google login is currently disabled.'));
            return redirect()->route('login');
        }

        $this->configure();

        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        if (get_settings('google_login_status') != '1') {
            Session::flash('error', get_phrase('Google login is currently disabled.'));
            return redirect()->route('login');
        }

        $this->configure();

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Session::flash('error', get_phrase('Google authentication failed. Please try again.'));
            return redirect()->route('login');
        }

        if (empty($googleUser->getEmail())) {
            Session::flash('error', get_phrase('Could not retrieve email from Google. Please try again.'));
            return redirect()->route('login');
        }

        // Find by google_id first, then by email
        $user = User::where('google_id', $googleUser->getId())->first()
            ?? User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Bind google_id if the account was registered with email/password
            if (empty($user->google_id)) {
                $user->update(['google_id' => $googleUser->getId()]);
            }

            if ($user->status == 0) {
                Session::flash('error', get_phrase('Your account has been disabled. Please contact support.'));
                return redirect()->route('login');
            }
        } else {
            // Register new student
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'role'              => 'student',
                'status'            => 1,
                'email_verified_at' => Carbon::now(),
                'password'          => bcrypt(Str::random(24)),
            ]);
        }

        Auth::login($user, true);

        return redirect(RouteServiceProvider::HOME);
    }
}
