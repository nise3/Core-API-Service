<?php

namespace App\Providers;

use App\Services\UserRolePermissionManagementServices\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

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
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('token', function ($request) {
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
        });
    }
}
