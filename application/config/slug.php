<?php

return [
    'max_length' => env('SLUG_MAX_LENGTH', 8),
    'default_redirect' => env('DEFAULT_REDIRECT', 'https://example.com/notfound'),
    'default_ttl_days' => env('DEFAULT_TTL_DAYS', 30)
];
