<?php

namespace App\Http\Middleware;

use App\Facade\AuthUser;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Log;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With,Token'
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $user = $this->fetchUserFromDB($request);
        AuthUser::setUser($user);

        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }

    private function fetchUserFromDB($request)
    {
        $token = $request->header('Token');
        Log::info("header: ".json_encode($request->header()));
        if ($token) {
            $header = explode(" ", $token);
            if (sizeof($header) > 1) {
                $tokenParts = explode(".", $header[1]);
                if (sizeof($tokenParts) == 3) {
                    $tokenPayload = base64_decode($tokenParts[1]);
                    $jwtPayload = json_decode($tokenPayload);
                    Log::info($jwtPayload);
                }
            }
        }
        return User::where('idp_user_id', $jwtPayload->sub ?? null)
            ->whereNotNull('idp_user_id')
            ->first();
    }
}
