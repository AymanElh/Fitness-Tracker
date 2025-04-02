<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View|object
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|object
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->userData());
        return redirect(route('dashboard'));
    }

}
