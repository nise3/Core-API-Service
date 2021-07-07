<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $client = new Client();

        try {
            return $client->post(config('services.passport.login_endpoint'), [
                "form_params" => [
                    "client_secret" => config('services.passport.client_secret'),
                    "grant_type" => "password",
                    "client_id" => config('services.passport.client_id'),
                    "username" => $request->email,
                    "password" => $request->password,
                ]
            ]);

        } catch (BadResponseException $ex) {
            return response()->json(['status' => 'error', 'message' => 'Please provide valid Email/Password']);
        }

    }

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->each(function ($token) {
                $token->delete();
            });

            return response()->json(['status' => 'success', 'message' => 'Logged out successfully']);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
        }
    }

    public function profile()
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => auth()->user(),
                'message' => 'Profile fetch successfully'
            ]);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
        }
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

        try {
            User::create([
                'name_en' => $request->name_en,
                'name_bn' => $request->name_bn,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type_id' => 1,
                'row_status' => 1,
            ]);

            return response()->json(['status' => 'success', 'message' => 'User created successfully']);

        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'message' => $ex->getMessage()]);
        }

    }
}
