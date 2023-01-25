<?php

namespace Src\Infrastructure\Clients\Http\CircuitBreaker;

class Config
{
    public readonly int $errorThreshold;

    public readonly int $successThreshold;

    public readonly int $timeoutWindow;

    public readonly int $halfOpenTimeout;

    public readonly int $errorTimeout;

    public function __construct()
    {
        /** @var array<string, int> $config */
        $config = config('infrastructure.circuit_breaker');

        $this->errorThreshold = $config['error_threshold'];
        $this->successThreshold = $config['success_threshold'];
        $this->timeoutWindow = $config['timeout_window'];
        $this->halfOpenTimeout = $config['half_open_timeout'];
        $this->errorTimeout = $config['error_timeout'];
    }
}
