<?php

namespace App\Http\Middleware;

use App\Models\BaseModel;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var Auth
     */
    protected Auth $auth;

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $guard = null)
    {
        if (!Auth::id()) {
            return response()->json([
                "_response_status" => [
                    "success" => false,
                    "code" => ResponseAlias::HTTP_UNAUTHORIZED,
                    "message" => "Unauthenticated action"
                ]
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        } else {
            /** @var User $authUser */
            $authUser = Auth::user();
            if ($authUser->isInstituteUser()) {
                $request->offsetSet('institute_id', $authUser->institute_id);
            } else if ($authUser->isOrganizationUser()) {
                $request->offsetSet('organization_id', $authUser->organization_id);
            } else if ($authUser->isIndustryAssociationUser()) {
                $request->offsetSet('industry_association_id', $authUser->industry_association_id);
            } else if ($authUser->isRtoUser()) {
                $request->offsetSet('registered_training_organization_id', $authUser->registered_training_organization_id);
            }
        }

        return $next($request);
    }
}
