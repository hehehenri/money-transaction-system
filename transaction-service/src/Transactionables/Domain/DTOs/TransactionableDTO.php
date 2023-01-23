<?php

namespace Src\Transactionables\Domain\DTOs;

use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

class TransactionableDTO
{
    public function __construct(
        public readonly ProviderId $providerId,
        public readonly Provider $provider
    ) {
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        return [
            'provider_id' => (string) $this->providerId,
            'provider' => $this->provider->value,
        ];
    }
}
