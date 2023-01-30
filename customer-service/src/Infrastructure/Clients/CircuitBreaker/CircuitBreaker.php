<?php

namespace Src\Infrastructure\Clients\CircuitBreaker;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CircuitBreaker
{
    private Config $config;

    public function __construct(
        private readonly string $service,
    ) {
        $this->config = new Config();
    }

    public function isAvailable(): bool
    {
        $isAvailable = ! $this->isOpen();

        if (! $isAvailable) {
            /** @phpstan-ignore-next-line  */
            Log::error(json_encode([
                'circuit_breaker' => [
                    'service' => $this->service,
                    'context' => 'Service unavailable.',
                ],
            ]));
        }

        return $isAvailable;
    }

    public function handleFailure(): void
    {
        if ($this->isHalfOpen()) {
            $this->openCircuit();

            return;
        }

        try {
            $this->incrementErrors();

            if ($this->reachedErrorThreshold() && ! $this->isOpen()) {
                $this->openCircuit();
            }
        } catch (Exception) {
            // Don't throw propagate if cache is down
        }
    }

    public function handleSuccess(): void
    {
        if (! $this->isHalfOpen()) {
            try {
                $this->reset();
            } catch (Exception) {
                // Don't propagate exception if cache is down
            }

            return;
        }

        $this->incrementSuccesses();

        if ($this->reachedSuccessThreshold()) {
            $this->reset();
        }
    }

    private function isOpen(): bool
    {
        try {
            $isOpen = Cache::get($this->getKey(Key::OPEN), 0);
        } catch (Exception) {
            // Returns false in case the cache is offline, so it won't block client calls.
            return false;
        }

        return (bool) $isOpen;
    }

    private function isHalfOpen(): bool
    {
        try {
            $isHalfOpen = (bool) Cache::get($this->getKey(Key::HALF_OPEN), 0);
        } catch (Exception) {
            // Returns false in case the cache is offline, so it won't block client calls.
            return false;
        }

        return ! $this->isOpen() && $isHalfOpen;
    }

    private function reachedErrorThreshold(): bool
    {
        $failures = $this->getErrorsCount();

        return $failures >= $this->config->errorThreshold;
    }

    private function reachedSuccessThreshold(): bool
    {
        $successes = $this->getSuccessesCount();

        return $successes >= $this->config->successThreshold;
    }

    private function incrementErrors(): void
    {
        $key = $this->getKey(Key::ERRORS);

        if (! Cache::get($key)) {
            Cache::put($key, 1, $this->config->timeoutWindow);
        }

        Cache::increment($key);
    }

    private function incrementSuccesses(): void
    {
        $key = $this->getKey(Key::SUCCESSES);

        if (! Cache::get($key)) {
            Cache::put($key, 1, $this->config->timeoutWindow);
        }

        Cache::increment($key);
    }

    private function reset(): void
    {
        foreach (Key::cases() as $key) {
            Cache::delete($this->getKey($key));
        }
    }

    private function setOpenCircuit(): void
    {
        /** @phpstan-ignore-next-line  */
        Log::error(json_encode([
            'circuit_breaker' => [
                'service' => $this->service,
                'context' => 'Reached limit threshold and opened.',
            ],
        ]));

        Cache::put(
            $this->getKey(Key::OPEN),
            time(),
            $this->config->errorTimeout
        );
    }

    private function setHalfOpenCircuit(): void
    {
        /** @phpstan-ignore-next-line  */
        Log::error(json_encode([
            'circuit_breaker' => [
                'service' => $this->service,
                'context' => 'Circuit turned half-open.',
            ],
        ]));

        Cache::put(
            $this->getKey(Key::HALF_OPEN),
            time(),
            $this->config->errorTimeout + $this->config->halfOpenTimeout
        );
    }

    private function getErrorsCount(): int
    {
        return (int) Cache::get(
            $this->getKey(Key::ERRORS),
            0
        );
    }

    private function getSuccessesCount(): int
    {
        return (int) Cache::get(
            $this->getKey(Key::SUCCESSES),
            0
        );
    }

    private function openCircuit(): void
    {
        $this->setOpenCircuit();
        $this->setHalfOpenCircuit();
    }

    private function getKey(?Key $key): string
    {
        return "circuit-breaker:{$this->service}:{$key?->value}";
    }
}
