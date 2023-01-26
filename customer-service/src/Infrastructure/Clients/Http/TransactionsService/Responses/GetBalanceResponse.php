<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Shared\ValueObjects\Money;

class GetBalanceResponse implements Response
{
    public function __construct(
        public readonly CustomerId $customerId,
        public readonly Money $balance,
    ) {
    }

    public static function deserialize(GuzzleResponse $response): self
    {
        /** @var  $jsonResponse */
        $jsonResponse = json_decode($response->getBody());

        $ledger = $jsonResponse['ledger'];

        return new self(
            new CustomerId($ledger['transactionable']['provider_id']),
            new Money((int) $ledger['balance']),
        );

    }
}
