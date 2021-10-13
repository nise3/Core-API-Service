<?php


namespace App\Services\AuthService;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthService
{
    /**
     * @param Request $request
     * @return JsonResponse | ResponseInterface
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

            return Response::json($response, ResponseAlias::HTTP_FORBIDDEN);

        } catch (GuzzleException $e) {
            $response = [
                '_response_status' => [
                    "success" => false,
                    "code" => $e->getCode(),
                    "message" => 'Opps! There is a problem in making the http call'
                ]
            ];
            return Response::json($response, 500);
        } finally {
            $response = [
                '_response_status' => [
                    "success" => false,
                    "code" => 500,
                    "message" => 'Opps! There is a problem in making the http call'
                ]
            ];
            return Response::json($response, 500);
        }

    }

    public function logout(): JsonResponse
    {
        try {
            auth()->user()->tokens()->each(function ($token) {
                $token->delete();
            });

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => 'Logged out successfully'
                ]
            ];
            return Response::json($response, ResponseAlias::HTTP_OK);

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
     * @return JsonResponse
     */
    public function getProfile(): JsonResponse
    {
        try {
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => 'Profile fetch successfully',
                    "data" => auth()->user()
                ]
            ];
            return Response::json($response, ResponseAlias::HTTP_OK);

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
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $user = User::create([
                'name_en' => $request->name_en,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type_id' => 1,
                'row_status' => 1,
            ]);

            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => 'User Created Successfully',
                    "data" => $user
                ]
            ];
            return Response::json($response, ResponseAlias::HTTP_OK);

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
