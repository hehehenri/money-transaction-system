<?php

namespace Src\Ledger\Presentation\Rest\ViewModels;

use Src\Ledger\Presentation\Exceptions\InvalidPayload;
use Src\Ledger\Presentation\Rest\Requests\ShowRequest;
use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ProviderId;

class ShowLedgerViewModel
{
    public function __construct(
        public readonly ProviderId $providerId,
        public readonly Provider $provider,
    ) {
    }

    /**
     * @throws InvalidPayload
     */
    public static function fromRequest(ShowRequest $request): self
    {
        /** @var array<string, string> $payload */
        $payload = $request->validated();
        $provider = Provider::tryFrom($payload['provider']);

        if (! $provider) {
            throw InvalidPayload::providerDontExists($payload['provider']);
        }

        return new self(
            new ProviderId($payload['provider_id']),
            $provider
        );
    }
}
