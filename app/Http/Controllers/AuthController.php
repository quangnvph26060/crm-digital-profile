<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auths\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginForm()
    {
        return view('auths.login');
    }

    public function loginFormAdmin()
    {
        return view('admins.pages.auths.login');
    }

    public function resetPassword($token)
    {
        return view('auths.reset_password', ['token' => $token]);
    }

    public function postResetPassword(ResetPasswordRequest $request, $token)
    {
        $result = $this->authService->postResetPassword($request->except('_token'), $token);

        if ($result['success']) {
            return redirect()->route('login')->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    public function forgetPassword()
    {
        return view('auths.forget_password');
    }

    public function postForgetPassword(ForgetPasswordRequest $request)
    {
        $result = $this->authService->postForgetPassword($request->except('_token'));

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    public function postLoginAdmin(LoginRequest $request)
    {
        $result = $this->authService->postLoginAdmin($request->except('_token'));

        if ($result['success']) {
            return redirect()->route('admin.mission.list');
        } else {
            return back()->with('error', $result['message']);
        }
    }

    public function postLogin(LoginRequest $request)
    {
        $result = $this->authService->postLogin($request->except('_token'));

        if ($result['success']) {
            return redirect()->route('customer.index');
        } else {
            return back()->withInput()->with('error', $result['message']);
        }
    }

    public function registerForm()
    {
        return view('auths.register');
    }

    public function verifyEmail($token)
    {
        $result = $this->authService->verifyEmail($token);

        return view('auths.verify_email', $result);
    }

    public function postRegister(RegisterRequest $request)
    {
        $result = $this->authService->postRegister($request->except('_token'));

        if ($result['success']) {
            return back()->withInput()->with('success', $result['message']);
        } else {
            return back()->withInput()->with('error', $result['message']);
        }
    }
}
