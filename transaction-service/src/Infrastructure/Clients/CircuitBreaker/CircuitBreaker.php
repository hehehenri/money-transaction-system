<?php

namespace Src\Infrastructure\Clients\CircuitBreaker;

class CircuitBreaker
{
    private State $state;

    private int $errorsCount;

    private int $successesCount;

    public function __construct()
    {
        $this->reset();
    }

    public function isAvailable(): bool
    {
        return $this->state !== State::OPEN;
    }

    public function handleFailure(): void
    {
        match ($this->state) {
            State::HALF_OPEN => $this->openCircuit(),
            State::OPEN => $this->incrementErrors(),
            State::CLOSED => function () {
                if ($this->reachedErrorThreshold()) {
                    $this->incrementErrors();
                    $this->openCircuit();
                }
            }
        };
    }

    public function handleSuccess(): void
    {
        if ($this->state !== State::HALF_OPEN) {
            $this->reset();
        }

        $this->incrementSuccesses();

        if ($this->reachedSuccessThreshold()) {
            $this->reset();
        }
    }

    private function openCircuit(): void
    {
        $this->state = State::OPEN;
    }

    private function errorThreshold(): int
    {
        /** @var int $threshold */
        $threshold = config('clients.circuit_breaker.error_threshold');

        return $threshold;
    }

    private function successThreshold(): int
    {
        /** @var int $threshold */
        $threshold = config('clients.circuit_breaker.success_threshold');

        return $threshold;
    }

    private function reachedErrorThreshold(): bool
    {
        return $this->errorsCount >= $this->errorThreshold();
    }

    private function reachedSuccessThreshold(): bool
    {
        return $this->successesCount >= $this->successThreshold();
    }

    private function incrementErrors(): void
    {
        $this->errorsCount++;
    }

    private function incrementSuccesses(): void
    {
        $this->successesCount++;
    }

    private function reset(): void
    {
        $this->state = State::CLOSED;
        $this->successesCount = 0;
        $this->errorsCount = 0;
    }
}
