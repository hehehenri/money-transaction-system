<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Payloads;

use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;

class GetTransactionsPayload implements TransactionServicePayload
{
    public function __construct(private readonly ShopkeeperId $id)
    {
    }

    /** @return array<string, string> */
    public function jsonSerialize(): array
    {
        /** @var string $provider */
        $provider = config('services.current_service_name');

        return [
            'provider_id' => $this->id,
            'provider' => $provider,
        ];
    }
}
