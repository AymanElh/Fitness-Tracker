<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    protected AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
//        dd($request->credentials());
        if($this->authService->login($request->credentials()))
        {
            $request->session()->regenerate();
//            dd("user logged in");
            $user = Auth::user();
            if($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return back()->withErrors(['email' => "These credentials doesn't match our records"]);
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect('/');
    }
}
