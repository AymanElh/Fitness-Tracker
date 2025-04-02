<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    protected AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showResetForm(Request $request, string $token = null)
    {
//        dd($request->all());
        return view('auth.reset-password')->with(['token' => $token, 'email' => $request->email]);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $reset = $this->authService->resetPassword($request->credentials());
        if($reset) {
            return redirect()->route('login')->with('status', "Password updated successfully");
        }
        return back()->withErrors(['email' => "Invalid token"]);
    }


}
