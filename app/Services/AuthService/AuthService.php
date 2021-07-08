<?php


namespace App\Services\AuthService;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthService
{
    /**
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
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

        } catch (BadResponseException $e) {
            $response = [
                '_response_status' => [
                    "success" => false,
                    "code" => $e->getCode(),
                    "message" => 'Please provide valid Email/Password'
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_FORBIDDEN);
        }
    }

    /**
     * @return array
     */
    public function logout(){
        try {
            auth()->user()->tokens()->each(function ($token) {
                $token->delete();
            });

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => 'Logged out successfully'
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_OK);

        } catch (\Exception $ex) {
            $response = [
                '_response_status' => [
                    "success" => false,
                    "code" => $ex->getCode(),
                    "message" => $ex->getMessage()
                ]
            ];
            return Response::json($response, $ex->getCode());
        }
    }

    /**
     * @return array
     */
    public function getProfile(){
        try {
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => 'Profile fetch successfully',
                    "data" => auth()->user()
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_OK);

        } catch (\Exception $ex) {
            $response = [
                '_response_status' => [
                    "success" => false,
                    "code" => $ex->getCode(),
                    "message" => $ex->getMessage()
                ]
            ];
            return Response::json($response, $ex->getCode());
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function register(Request $request){
        try {
            $user = User::create([
                'name_en' => $request->name_en,
                'name_bn' => $request->name_bn,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type_id' => 1,
                'row_status' => 1,
            ]);

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => 'User Created Successfully',
                    "data" => $user
                ]
            ];
            return Response::json($response, JsonResponse::HTTP_OK);

        } catch (\Exception $ex) {
            $response = [
                '_response_status' => [
                    "success" => false,
                    "code" => $ex->getCode(),
                    "message" => $ex->getMessage()
                ]
            ];
            return Response::json($response, $ex->getCode());
        }
    }
}
