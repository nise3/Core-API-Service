<?php

namespace App\Providers;

use App\Services\UserRolePermissionManagementServices\UserService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('token', function ($request) {
            $token = $request->bearerToken();
            Log::info('Bearer Token: ' . $token);

            if (!$token) {
                return null;
            }

            Log::info($token);
            $authUser = null;

            $idpServerId = $this->getIdpServerIdFromToken($token);
            Log::info("Auth idp user id-->" . $idpServerId);
            if ($idpServerId) {
                $userService = $this->app->make(UserService::class);
                $authUser = $userService->getAuthPermission($idpServerId);
                Log::info("userInfoWithIdpId:" . json_encode($authUser));

            }

            return $authUser;
            /*
                        // Old Code
                        $token = $request->header('Authorization');
                        $authUser = null;
                        if ($token) {
                            $header = explode(" ", $token);
                            if (count($header) > 1) {
                                $tokenParts = explode(".", $header[1]);
                                if (count($tokenParts) == 3) {
                                    $tokenPayload = base64_decode($tokenParts[1]);
                                    $jwtPayload = json_decode($tokenPayload);
                                    $userService = $this->app->make(UserService::class);
                                    $authUser = $userService->getAuthPermission($jwtPayload->sub ?? null);
                                }
                            }
                            Log::info("userInfoWithIdpId:" . json_encode($authUser));
                        }
                        return $authUser;
            */
        });
    }

    public function getIdpServerIdFromToken($data, bool $verify = false): mixed
    {
        $sections = explode('.', $data);

        throw_if((count($sections) < 3), AuthenticationException::class, 'Invalid number of sections of Auth Tokens (<3)', Response::HTTP_BAD_REQUEST);

        list($header, $claims, $signature) = $sections;

        preg_match("/['\"]sub['\"]:['\"](.*?)['\"][,]/", base64_decode($claims), $matches);

        return count($matches) > 1 ? $matches[1] : "";
    }
}
