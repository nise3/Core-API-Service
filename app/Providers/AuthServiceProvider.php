<?php

namespace App\Providers;

use App\Facade\AuthTokenUtility;
use App\Facade\ServiceToServiceCall;
use App\Models\Role;
use App\Models\User;
use App\Services\UserRolePermissionManagementServices\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    private array $policies = [];

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
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        if (count($this->policies)) {
            /** Registering Policies
             * @var string $modelName
             * @var string $policyName
             */
            foreach ($this->policies as $modelName => $policyName) {
                Gate::policy($modelName, $policyName);
            }
        }

        $this->app['auth']->viaRequest('token', function (Request $request) {

            $token = $request->bearerToken();
            Log::info('Bearer Token: ' . $token);

            if (!$token) {
                return null;
            }

            $authUser = null;
            $idpServerUserId = AuthTokenUtility::getIdpServerIdFromToken($token);

            Log::info("Auth idp user id-->" . $idpServerUserId);

            if ($idpServerUserId) {

                Cache::remember($idpServerUserId, config('nise3.user_cache_ttl'), function () use ($idpServerUserId, $authUser) {
                    $userService = $this->app->make(UserService::class);
                    $authUser = $userService->getAuthPermission($idpServerUserId);
                    Log::info("userInfoWithIdpId:" . json_encode($authUser));
                    return $authUser;
                });

                /** Remove cache key when value is null. Null can be set through previous cache remember function */
                if (Cache::get($idpServerUserId) == null) {
                    Cache::forget($idpServerUserId);
                }
            }

            return Cache::get($idpServerUserId);
        });
    }
}
