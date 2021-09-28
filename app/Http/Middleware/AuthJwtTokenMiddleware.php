<?php

namespace App\Http\Middleware;

use App\Facade\AuthUser;
use App\Models\Role;
use App\Models\User;
use App\Services\UserRolePermissionManagementServices\UserService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isEmpty;

class AuthJwtTokenMiddleware
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With,Token'
        ];

        $this->fetchUserFromDB($request);
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }
        return $response;
    }


    /**
     * @param $request
     */
    private function fetchUserFromDB($request)
    {
//        $token = $request->header('Token');
//        if ($token) {
//            $header = explode(" ", $token);
//            if (sizeof($header) > 1) {
//                $tokenParts = explode(".", $header[1]);
//                if (sizeof($tokenParts) == 3) {
//                    $tokenPayload = base64_decode($tokenParts[1]);
//                    $jwtPayload = json_decode($tokenPayload);
//                }
//            }
//
//            $authUser = $this->userService->getAuthPermission($jwtPayload->sub ?? null);
//            Log::info("userInfoWithIdpId:" . json_encode($authUser));
////            if($authUser){
////                Auth::setUser($authUser);
////                Auth::shouldUse('api');
////            }
//        }
    }
}
