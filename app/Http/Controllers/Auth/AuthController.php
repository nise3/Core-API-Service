<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @var authService
     */
    private AuthService $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        return $this->authService->login($request);

    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function profile()
    {
        return $this->authService->getProfile();
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'email' => 'required|string'
        ]);
    }

    protected function validateRegister(Request $request)
    {
        $this->validate($request, [
            'name_en' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    public function register(Request $request)
    {
        $this->validateRegister($request);

        return $this->authService->register($request);

    }
}
