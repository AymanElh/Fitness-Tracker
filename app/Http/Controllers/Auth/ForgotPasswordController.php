<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    protected AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showForgetPasswordForm()
    {
        return view('auth.forget-password');
    }

    public function sendResetLink(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        $token = $this->authService->sendPasswordResetLink($data['email']);
        if($token) {
            \Log::info('Password reset token for ' . $request->email . ': ' . $token);
//        dd($token, $data['email']);
            return back()->with('status', "We have sent you a link on your email to reset your password");
        }

        return back()->withErrors(['email' => "We can't find user with that email address"]);
    }
}
