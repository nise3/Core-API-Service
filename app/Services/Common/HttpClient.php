<?php

namespace App\Services\Common;

use App\Models\BaseModel;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class HttpClient extends Http
{

    /**
     * @param array $postField
     * @return PromiseInterface|Response
     */
    public function idpUserCreate(array $postField)
    {
        $data = [
            'name' => $postField['name_en'],
            'email' => $postField['email'],
            'username' => $postField['username'],
            'password' => $postField['password']
        ];

        $client = Http::withBasicAuth(BaseModel::IDP_USERNAME, BaseModel::IDP_USER_PASSWORD)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ])->withOptions([
                'verify' => false
            ])->post(BaseModel::IDP_USER_CREATE_ENDPOINT, [
                'schemas' => [
                ],
                'name' => [
                    'familyName' => $data['name'],
                    'givenName' => $data['name']
                ],
                'userName' => $data['username'],
                'password' => $data['password'],
                'emails' => [
                    0 => [
                        'primary' => true,
                        'value' => $data['email'],
                        'type' => 'work',
                    ]
                ],
            ]);

        Log::channel('idp_user')->info('idp_user_payload', $data);
        Log::channel('idp_user')->info('idp_user_info', $client->json());
        return $client;
    }

}
