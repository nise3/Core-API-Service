<?php

namespace App\Helpers\Classes;

use App\Exceptions\HttpErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;
use Firebase\JWT\CachedKeySet;
use Firebase\JWT\JWT;

class AuthTokenUtilityHandler
{
    private const _WSO2_KEY = '';

    /**
     * @param $data
     * @param false $verify
     * @return mixed
     * @throws Throwable
     */
    public function getIdpServerIdFromToken($data, bool $verify = false): mixed
    {
        $payload = $this->decode($data);
        return $payload->sub;
    }

    /**
     * @param $data
     * @param false $verify
     * @return mixed
     * @throws Throwable
     */
    public function getIdpServerUserTypeFromToken($data, bool $verify = false): mixed
    {
        $payload = $this->decode($data);

        return $payload->user_type;
    }

    /**
     * @return string
     */
    private function getJwtKey(): string
    {
        return self::_WSO2_KEY;
    }

    private function verify($token): bool
    {
        return true;
    }

    /**
     * Verify Signature
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function jwtTokenValidationV1($token): bool
    {
        Log::info('verify - Token: ' . $token);
        $tokenValidationEndpoint = env('WSO2_IDP_BASE_URL', 'https://192.168.13.206:9448') . '/oauth2/introspect';
        $idpAdminUser = env('WSO2_IDP_USERNAME', 'admin');
        $idpAdminPassword = env('WSO2_IDP_PASSWORD', 'admin');

        $tokenDetails = Http::withoutVerifying()
            ->withOptions([
                'debug' => false,
                'verify' => false
            ])
            ->withBasicAuth($idpAdminUser, $idpAdminPassword)
            ->withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Cache-Control' => 'no-cache'
            ])
            ->timeout(15)
            ->post($tokenValidationEndpoint, [
                'token' => $token,
            ])
            ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($tokenValidationEndpoint) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $tokenValidationEndpoint . ' and Response:: ' . $httpResponse->body());
//                throw new HttpErrorException($httpResponse);
            })
            ->json();

        Log::info('Verify Token Response: ');
        Log::info($tokenDetails);

        return true;
    }

    public function jwtTokenValidation($token): bool
    {
        try {
            $curl = curl_init();
            $tokenValidationEndpoint = env('WSO2_IDP_BASE_URL', 'https://192.168.13.206:9448') . '/oauth2/introspect';

            $idpAdminUser = env('WSO2_IDP_USERNAME', 'admin');
            $idpAdminPassword = env('WSO2_IDP_PASSWORD', 'admin');

            curl_setopt_array($curl, array(
                CURLOPT_URL => $tokenValidationEndpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POSTFIELDS => "token={$token}",
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . base64_encode($idpAdminUser . ':' . $idpAdminPassword),
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            Log::info('verifyV2');
            $responseArr = json_decode($response, true);

            Log::debug($responseArr);
            if (is_array($responseArr) && isset($responseArr['active'])) {
                return $responseArr['active'];
            }

        } catch (\Throwable $e) {
            Log::debug($e);
        }

        return false;
    }

    /**
     * @throws Throwable
     */
    private function decode($token)
    {

        $tks = explode('.', $token);

        throw_if((count($tks) < 3), AuthenticationException::class, 'Invalid number of sections of Tokens (<3)',);

        list($header, $body, $signature) = $tks;
        $input = $body;
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        $input = (base64_decode(strtr($input, '-_', '+/')));

        $max_int_length = strlen((string)PHP_INT_MAX) - 1;
        $json_without_bigints = preg_replace('/:\s*(-?\d{' . $max_int_length . ',})/', ': "$1"', $input);

        return json_decode($json_without_bigints);
    }

    public function validateJwtUserTokenRaw($token)
    {

//
//// The URI for the JWKS you wish to cache the results from
//        $jwksUri = 'https://www.gstatic.com/iap/verify/public_key-jwk';
//
//// Create an HTTP client (can be any PSR-7 compatible HTTP client)
//        $httpClient = new GuzzleHttp\Client();
//
//// Create an HTTP request factory (can be any PSR-17 compatible HTTP request factory)
//        $httpFactory = new GuzzleHttp\Psr\HttpFactory();
//
//// Create a cache item pool (can be any PSR-6 compatible cache item pool)
//        $cacheItemPool = Phpfastcache\CacheManager::getInstance('files');
//
//        $keySet = new CachedKeySet(
//            $jwksUri,
//            $httpClient,
//            $httpFactory,
//            $cacheItemPool,
//            null, // $expiresAfter int seconds to set the JWKS to expire
//            true  // $rateLimit    true to enable rate limit of 10 RPS on lookup of invalid keys
//        );
//
//        $jwt = 'eyJhbGci...'; // Some JWT signed by a key from the $jwkUri above
//        $decoded = JWT::decode($jwt, $keySet);
    }
}
