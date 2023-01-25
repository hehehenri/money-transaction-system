<?php

namespace Src\Transactions\Presentation\Rest\ViewModels;

use Src\Transactionables\Domain\Enums\Provider;
use Src\Transactionables\Domain\ValueObjects\ProviderId;
use Src\Transactions\Presentation\Exceptions\InvalidPayloadException;
use Src\Transactions\Presentation\Rest\Requests\ListTransactionsRequest;

class ListTransactionsViewModel
{
    
    public function __construct(
        public readonly ProviderId $providerId,
        public readonly Provider $provider,
        public readonly int $perPage,
        public readonly int $page,
    ) {
    }

    /**
     * @throws InvalidPayloadException
     */
    public static function fromRequest(ListTransactionsRequest $request): self
    {
        /** @var array<string, string> $payload */
        $payload = $request->validated();
        $provider = Provider::tryFrom($payload['provider']);

        if (! $provider) {
            throw InvalidPayloadException::invalidProvider($payload['provider_id']);
        }

        return new self(
            new ProviderId($payload['provider_id']),
            $provider,
            (int) $payload['per_page'],
            (int) $payload['page']
        );
    }
}
