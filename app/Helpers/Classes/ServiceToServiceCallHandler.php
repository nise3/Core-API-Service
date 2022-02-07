<?php

namespace App\Helpers\Classes;

use App\Exceptions\HttpErrorException;
use App\Models\BaseModel;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServiceToServiceCallHandler
{

    /**
     * @param string $idpUserId
     * @return mixed
     * @throws RequestException
     */
    public function getAuthUserWithRolePermission(string $idpUserId): mixed
    {
        $postUrl = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'auth-user-info';

        $userPostField = [
            "idp_user_id" => $idpUserId
        ];

        Log::debug("Http/Curl call error. Destination:: " . $postUrl . ' and Response:: ');

        $responseData = Http::withOptions(
            [
                'verify' => config('nise3.should_ssl_verify'),
                'debug' => config('nise3.http_debug'),
                'timeout' => config('nise3.http_timeout'),
            ])
            ->post($postUrl, $userPostField)
            ->throw(static function (Response $httpResponse, $httpException) use ($postUrl) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $postUrl . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json('data');


        Log::info("userInfo:" . json_encode($responseData));

        return $responseData;
    }
}
