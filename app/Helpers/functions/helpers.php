<?php

use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('urlGenerator')) {
    /**
     * @return \Laravel\Lumen\Routing\UrlGenerator
     */
    function urlGenerator() {
        return new \Laravel\Lumen\Routing\UrlGenerator(app());
    }
}

if (!function_exists('asset')) {
    /**
     * @param $path
     * @param bool $secured
     *
     * @return string
     */
    function asset($path, $secured = false) {
        return urlGenerator()->asset($path, $secured);
    }
}

if (!function_exists('formatApiResponse')) {
    /**
     * @param $path
     * @param bool $secured
     *
     * @return array
     */
    function formatApiResponse($data, $startTime, $statusCode = 200): array
    {
        return [
            "data" => $data ?: null,
            "_response_status" => [
                "success" => true,
                "code" => $startTime,
                "query_time" => $startTime->diffForHumans(Carbon::now())
            ]
        ];
    }
}
