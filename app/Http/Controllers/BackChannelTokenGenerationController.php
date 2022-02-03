<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BackChannelTokenGenerationController extends Controller
{
    /**
     * @throws AuthorizationException
     * @throws RequestException
     */
    public function ssoRenewAccessToken(Request $request)
    {
        Log::debug('refresh token: ' . $request->input('refresh_token'));

        $basicAuth = 'Basic ' . base64_encode(env('WSO2_IDP_CLIENT_KEY', 'FhVqwNp6Q6FV1H8KuuLsh5REQysa') . ':' . env('WSO2_IDP_CLIENT_SECRET', 'GfrDpy904LjaWNmn7aSwEA1qyEQa'));

        $postUrl = env('WSO2_IDP_BASE_URL', 'https://identity-dev.nise3.xyz') . "/oauth2/token?grant_type=refresh_token&refresh_token=" . $request->input('refresh_token');

        $responseData = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $basicAuth,
        ])
            ->withOptions([
                'follow_redirects' => true,
                'verify' => false,
                'debug' => false
            ])
            ->post($postUrl)
            ->throw(static function ($exception) {
                Log::debug($exception);
                throw $exception;
            });

        $response = $responseData->json();

        Log::debug('SSO New Access Token: ');

        Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED);
        }

        return $response;
    }

    /**
     * @throws AuthorizationException
     * @throws RequestException
     */
    public function ssoAuthorizeCodeGrant(Request $request)
    {
        Log::debug('ssoAuthorizeCodeGrant: ');

        $basicAuth = 'Basic ' . base64_encode(env('WSO2_IDP_CLIENT_KEY', 'FhVqwNp6Q6FV1H8KuuLsh5REQysa') . ':' . env('WSO2_IDP_CLIENT_SECRET', 'GfrDpy904LjaWNmn7aSwEA1qyEQa'));
        $postUrl = env('WSO2_IDP_BASE_URL', 'https://identity-dev.nise3.xyz') . '/oauth2/token?grant_type=authorization_code&code=' . $request->input('code') . '&redirect_uri=' . urlencode($request->input('redirect_uri'));

        $responseData = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => $basicAuth,
        ])
            ->withOptions([
                'follow_redirects' => true,
                'verify' => false,
                'debug' => false
            ])
            ->post($postUrl)
            ->throw(static function ($exception) {
                Log::debug($exception);
                throw $exception;
            });

        $response = $responseData->json();
        Log::debug('SSO Access Token: ');
        Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), Response::HTTP_UNAUTHORIZED);
        }

        return $response;

    }

    /**
     * @throws AuthorizationException
     * @throws RequestException
     */
    public function apimAppApiAccessToken(Request $request)
    {
        Log::debug('APP Access Token: ');
        $responseData = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode(env('WSO2_APIM_CLIENT_KEY') . ':' . env('WSO2_APIM_CLIENT_SECRET')),
        ])
            ->withOptions([
                'follow_redirects' => true,
                'verify' => false,
                'debug' => false
            ])
            ->post(env('WSO2_APIM_BASE_URL', 'https://apim-dev.nise3.xyz') . '/oauth2/token', [
                'grant_type' => 'client_credentials'
            ])
            ->throw(static function ($exception) {
                Log::debug($exception);
                throw $exception;
            });

        $response = $responseData->json();

        Log::debug('APP Access Token: ');
        Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), Response::HTTP_UNAUTHORIZED);
        }

        return $response;
    }
}
