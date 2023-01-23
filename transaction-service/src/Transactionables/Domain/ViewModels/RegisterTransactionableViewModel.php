<?php

namespace Src\Transactionables\Domain\ViewModels;

use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

class RegisterTransactionableViewModel
{
    public function __construct(
        public readonly ProviderId $providerId,
        public readonly Provider $provider
    ) {
    }

    /** @param  array<string, string>  $deserialized */
    public static function jsonSerialize(array $deserialized): self
    {
        return new self(
            new ProviderId($deserialized['provider_id']),
            Provider::from($deserialized['provider']),
        );
    }
}
