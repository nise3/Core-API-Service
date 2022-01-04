<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BackChannelTokenGenerationController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function ssoRenewAccessToken(Request $request)
    {
        \Illuminate\Support\Facades\Log::debug('refresh token: ' . $request->input('refresh_token'));

        $basicAuth = 'Basic ' . base64_encode(env('WSO2_IDP_CLIENT_KEY', 'FhVqwNp6Q6FV1H8KuuLsh5REQysa') . ':' . env('WSO2_IDP_CLIENT_SECRET', 'GfrDpy904LjaWNmn7aSwEA1qyEQa'));

        $postUrl = env('WSO2_IDP_BASE_URL', 'https://bus-staging.softbdltd.com/') . "oauth2/token?grant_type=refresh_token&refresh_token=" . $request->input('refresh_token');

        $responseData = \Illuminate\Support\Facades\Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $basicAuth,
        ])->withOptions([
            'follow_redirects' => true,
            'verify' => false,
            'debug' => false
        ])
            ->post($postUrl);

        $response = $responseData->json();

        \Illuminate\Support\Facades\Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);
        }

        return $response;
    }

    /**
     * @throws AuthorizationException
     */
    public function ssoAuthorizeCodeGrant(Request $request)
    {
        $basicAuth = 'Basic ' . base64_encode(env('WSO2_IDP_CLIENT_KEY', 'FhVqwNp6Q6FV1H8KuuLsh5REQysa') . ':' . env('WSO2_IDP_CLIENT_SECRET', 'GfrDpy904LjaWNmn7aSwEA1qyEQa'));
        $postUrl = env('WSO2_IDP_BASE_URL', 'https://bus-staging.softbdltd.com/') . 'oauth2/token?grant_type=authorization_code&code=' . $request->input('code') . '&redirect_uri=' . urlencode($request->input('redirect_uri'));


        $responseData = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $basicAuth,
        ])->withOptions([
            'follow_redirects' => true,
            'verify' => false,
            'debug' => false
        ])
            ->post($postUrl);

        $response = $responseData->json();

        Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), Response::HTTP_UNAUTHORIZED);
        }

        return $response;

    }

    /**
     * @throws AuthorizationException
     */
    public function apimAppApiAccessToken(Request $request)
    {
        $responseData = Http::withHeaders([
            'Authorization' => 'Basic RmhWcXdOcDZRNkZWMUg4S3V1THNoNVJFUXlzYTpHZnJEcHk5MDRMamFXTm1uN2FTd0VBMXF5RVFh',
        ])->withOptions([
            'follow_redirects' => true,
            'verify' => false,
            'debug' => false
        ])->post('https://bus-staging.softbdltd.com/oauth2/token', [
            'grant_type' => 'client_credentials'
        ]);

        $response = $responseData->json();

        Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), Response::HTTP_UNAUTHORIZED);
        }

        return $response;
    }
}
