<?php

namespace App\Providers;

use App\Helpers\Classes\HttpClientRequest;
use App\Models\Role;
use App\Models\User;
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
            Log::info($token);
            $authUser = null;
            if ($token) {
                //$header = explode(" ", $token);
                $token = trim(str_replace('Bearer', '', $token));

                $idpServerId = $this->getIdpServerIdFromToken($token);
                Log::info("Auth idp user id-->" . $idpServerId);
                if($idpServerId){
                    $userService = $this->app->make(UserService::class);
                    $authUser = $userService->getAuthPermission($idpServerId);
                    Log::info("userInfoWithIdpId:" . json_encode($authUser));
                    return $authUser;
                }
            }

//            $token = $request->header('Authorization');
//            $authUser = null;
//            if ($token) {
//                $header = explode(" ", $token);
//                if (count($header) > 1) {
//                    $tokenParts = explode(".", $header[1]);
//                    if (count($tokenParts) == 3) {
//                        $tokenPayload = base64_decode($tokenParts[1]);
//                        $jwtPayload = json_decode($tokenPayload);
//                        $userService = $this->app->make(UserService::class);
//                        $authUser = $userService->getAuthPermission($jwtPayload->sub ?? null);
//                    }
//                }
//                Log::info("userInfoWithIdpId:" . json_encode($authUser));
//            }
//            return $authUser;
        });
    }

    private function getIdpServerIdFromToken($data, $verify = false)
    {
        $sections = explode('.', $data);
        if (count($sections) < 3) {
            throw new \Exception('Invalid number of sections of Tokens (<3)');
        }

        list($header, $claims, $signature) = $sections;
        preg_match("/['\"]sub['\"]:['\"](.*?)['\"][,]/", base64_decode($claims), $matches);

        return count($matches) > 1 ? $matches[1] : "";
    }
}
