<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->sendAuthenticationMail();
        }

        return back()->with('message', 'Un lien magique a été envoyé à votre adresse e-mail.');
    }

    public function callback(Request $request)
    {
        $email = $request->query('email');
        $token = $request->query('token');
        $redirectTo = $request->query('redirect_to', '/home');

        $user = User::where('email', $email)->firstOrFail();
        $authService = new AuthenticationService($user);

        if ($authService->checkToken($token)) {
            Auth::login($user);
            return redirect($redirectTo);
        }

        return redirect()->route('login')->withErrors('Lien invalide ou expiré.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login');
    }
}
