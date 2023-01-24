<?php

namespace Src\Infrastructure\Clients\CircuitBreaker;

use Illuminate\Support\Facades\Cache;

class CircuitBreaker
{
    public function __construct(
        private readonly string $service,
        private readonly Cache $cache,
        private readonly Config $config
    ) {
    }

    public function isAvailable(): bool
    {
        return ! $this->isOpen();
    }

    public function handleFailure(): void
    {
        if ($this->isHalfOpen()) {
            $this->openCircuit();

            return;
        }

        $this->incrementErrors();

        if ($this->reachedErrorThreshold() && ! $this->isOpen()) {
            $this->openCircuit();
        }
    }

    public function handleSuccess(): void
    {
        if (! $this->isHalfOpen()) {
            $this->reset();

            return;
        }

        $this->incrementSuccesses();

        if ($this->reachedSuccessThreshold()) {
            $this->reset();
        }
    }

    private function isOpen(): bool
    {
        return (bool) $this->cache->get($this->getKey(Key::OPEN), 0);
    }

    private function isHalfOpen(): bool
    {
        $isHalfOpen = (bool) $this->cache->get($this->getKey(Key::HALF_OPEN), 0);

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

        if (! $this->cache->get($key)) {
            $this->cache->put($key, 1, $this->config->timeoutWindow);
        }

        $this->cache->increment($key);
    }

    private function incrementSuccesses(): void
    {
        $key = $this->getKey(Key::SUCCESSES);

        if (! $this->cache->get($key)) {
            $this->cache->put($key, 1, $this->config->timeoutWindow);
        }

        $this->cache->increment($key);
    }

    private function reset(): void
    {
        foreach (Key::cases() as $key) {
            $this->cache->delete($this->getKey($key));
        }
    }

    private function setOpenCircuit(): void
    {
        $this->cache->put(
            $this->getKey(Key::OPEN),
            time(),
            $this->config->errorTimeout
        );
    }

    private function setHalfOpenCircuit(): void
    {
        $this->cache->put(
            $this->getKey(Key::HALF_OPEN),
            time(),
            $this->config->errorTimeout + $this->config->halfOpenTimeout
        );
    }

    private function getErrorsCount(): int
    {
        return (int) $this->cache->get(
            $this->getKey(Key::ERRORS),
            0
        );
    }

    private function getSuccessesCount(): int
    {
        return (int) $this->cache->get(
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
