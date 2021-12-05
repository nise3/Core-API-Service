<?php

return [
    "is_dev_mode" => env("IS_DEVELOPMENT_MOOD", false),
    "should_ssl_verify" => env("IS_SSL_VERIFY", false),
    'http_debug' => env("HTTP_DEBUG_MODE", false),
    "user_cache_ttl" => 86400
];
