<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpErrorException;
use Illuminate\Http\Client\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as SymfonyResonse;

class BackChannelTokenGenerationController extends Controller
{
    /**
     * @throws AuthorizationException
     * @throws RequestException
     */
    public function ssoRenewAccessToken(Request $request)
    {
        Log::debug('ssoRenewAccessToken');
        Log::debug($request->all());

        $oidcClientKey = env('WSO2_IDP_CLIENT_KEY', 'u13j1BX4H7VuuutmtkbI5z27_5Qa');
        $oidcClientSecret = env('WSO2_IDP_CLIENT_SECRET', 'Sygpg0CyFLLsXxO7ExytffHw7fwa');

        $postUrl = env('WSO2_IDP_BASE_URL', 'https://identity-dev.nise3.xyz') . "/oauth2/token?grant_type=refresh_token&refresh_token=" . $request->input('refresh_token');

        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])
            ->withBasicAuth($oidcClientKey, $oidcClientSecret)
            ->timeout(120)
            ->withOptions([
                'allow_redirects' => ['strict' => true],
                'verify' => false,
                'debug' => false
            ])
            ->post($postUrl)
            ->throw(static function (Response $httpResponse, $httpException) use ($postUrl) {
                Log::debug('ssoRenewAccessToken');
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $postUrl . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json();

        Log::debug('SSO New Access Token: ');

        Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), SymfonyResonse::HTTP_UNAUTHORIZED);
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
        Log::debug($request->all());

        $oidcClientKey = env('WSO2_IDP_CLIENT_KEY', 'u13j1BX4H7VuuutmtkbI5z27_5Qa');
        $oidcClientSecret = env('WSO2_IDP_CLIENT_SECRET', 'Sygpg0CyFLLsXxO7ExytffHw7fwa');

        $postUrl = env('WSO2_IDP_BASE_URL', 'https://identity-dev.nise3.xyz') . '/oauth2/token?grant_type=authorization_code&code=' . $request->input('code') . '&redirect_uri=' . urlencode($request->input('redirect_uri'));

        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])
            ->withBasicAuth($oidcClientKey, $oidcClientSecret)
            ->timeout(120)
            ->withOptions([
                'allow_redirects' => ['strict' => true],
                'verify' => false,
                'debug' => false
            ])
            ->post($postUrl)
            ->throw(static function (Response $httpResponse, $httpException) use ($postUrl) {
                Log::debug('ssoAuthorizeCodeGrant');
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $postUrl . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json();

        Log::debug('SSO Access Token: ');
        Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), SymfonyResonse::HTTP_UNAUTHORIZED);
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
        Log::debug($request->all());

        $postUrl = env('WSO2_APIM_BASE_URL', 'https://apim-dev.nise3.xyz') . '/oauth2/token';

        $clientConsumerKey = env('WSO2_APIM_CLIENT_KEY');
        $clientConsumerSecret = env('WSO2_APIM_CLIENT_SECRET');

        $response = Http::withBasicAuth($clientConsumerKey, $clientConsumerSecret)
            ->timeout(120)
            ->withOptions([
                'allow_redirects' => ['strict' => true],
                'verify' => false,
                'debug' => false
            ])
            ->post($postUrl, [
                'grant_type' => 'client_credentials'
            ])
            ->throw(static function (Response $httpResponse, $httpException) use ($postUrl) {
                Log::debug('apimAppApiAccessToken');
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $postUrl . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json();

        Log::debug('APP Access Token: ');
        Log::debug($response);

        if (isset($response['error']) && $response['error']) {
            throw new AuthorizationException(json_encode($response), SymfonyResonse::HTTP_UNAUTHORIZED);
        }

        return $response;
    }
}
