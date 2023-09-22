<?php

return [
    'redmine_server' => [
        'base_url' => env('REDMINE_BASE_URL'),
        'api_key' => env('REDMINE_API_KEY'),
        'use_redmine' => env('USE_REDMINE_REST_APIS')
    ],
];