<?php

return [
    'circuit_breaker' => [
        'timeout_window' => 60,
        'error_threshold' => 10,
        'error_timeout' => 300,
        'half_open_timeout' => 150,
        'success_threshold' => 1,
    ],
    'http_client' => [
        'timeout' => 5,
    ],
];
