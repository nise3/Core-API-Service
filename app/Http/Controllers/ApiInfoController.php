<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Services\UserRolePermissionManagementServices\UserService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiInfoController extends Controller
{

    /**
     * @var Carbon
     */
    private Carbon $startTime;

    const SERVICE_NAME = 'NISE-3 Core Api Service';
    const SERVICE_VERSION = 'V1';

    /**
     * ApiInfoController constructor.
     * @param Carbon $startTime
     */
    public function __construct(Carbon $startTime)
    {
        $this->startTime = $startTime;
    }


    public function apiInfo(): JsonResponse
    {
        $response = [
            'service_name' => self::SERVICE_NAME,
            'service_version' => self::SERVICE_VERSION,
            'lumen_version' => App::version(),
            'modules' => [
                'UserRoleManagement' => [
                    'Permission',
                    'Role',
                    'User',
                    'PermissionGroup',
                    'PermissionSubGroup'
                ],
                'AuthManagement' => [
                    'Auth'
                ]
            ],
            'description' => 'It a core api service that manages Location Services,UserRoleManagement Services and Auth Services globally'

        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    public function domainDetails(Request $request): JsonResponse
    {
        $domain = $request->get('domain');

        $domain = Domain::where('domain', $domain)->firstOrFail();

        $response = [
            'data' => $domain,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Domain fetch successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    public function getDomain(Request $request): JsonResponse
    {
        $queryAttribute = null;
        $queryAttributeValue = null;

        if ($request->get('industry_association_id')) {
            $queryAttribute = "industry_association_id";
            $queryAttributeValue = $request->get('industry_association_id');
        } elseif ($request->get('industry_id')) {
            $queryAttribute = "industry_id";
            $queryAttributeValue = $request->get('industry_id');
        } elseif ($request->get('institute_id')) {
            $queryAttribute = "institute_id";
            $queryAttributeValue = $request->get('institute_id');
        }
        $domain = null;
        if ($queryAttribute && $queryAttributeValue) {
            $domain = Domain::where($queryAttribute, $queryAttributeValue)->firstOrFail()->domain;
        }

        $response = [
            'domain' => $domain,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Domain fetch successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now()),
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
