<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Payloads;

use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;

class GetBalancePayload implements TransactionServicePayload
{
    public function __construct(public readonly ShopkeeperId $ShopkeeperId)
    {
    }

    public function jsonSerialize(): array
    {
        /** @var string $provider */
        $provider = config('services.current_service_name');

        return [
            'provider_id' => (string) $this->ShopkeeperId,
            'provider' => $provider,
        ];
    }
}
