<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses;

use Psr\Http\Message\ResponseInterface;
use Src\Shopkeeper\Domain\ValueObjects\ShopkeeperId;
use Src\Shared\ValueObjects\Money;

class GetBalanceResponse implements Response
{
    public function __construct(
        public readonly ShopkeeperId $ShopkeeperId,
        public readonly Money $balance,
    ) {
    }

    public static function deserialize(ResponseInterface $response): self
    {
        /**
         * @var array{ledger: array{
         *              balance: int,
         *              transactionable:array<string, string>
         *          }
         *      } $jsonResponse
         */
        $jsonResponse = json_decode($response->getBody(), true);

        return new self(
            new ShopkeeperId($jsonResponse['ledger']['transactionable']['provider_id']),
            new Money((int) $jsonResponse['ledger']['balance']),
        );
    }
}
