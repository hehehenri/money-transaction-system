<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses;

use GuzzleHttp\Psr7\Response;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Shared\ValueObjects\Uuid;

class RegisterCustomerResponse implements \Src\Infrastructure\Clients\Http\TransactionsService\Responses\Response
{
    public function __construct(
        public readonly Uuid $id,
        public readonly string $provider,
        public readonly CustomerId $providerId
    ) {
    }

    public static function deserialize(Response $response): self
    {
        /** @var array<string, array<string, string>> $jsonResponse */
        $jsonResponse = json_decode($response->getBody(), true);

        $transactionable = $jsonResponse['transactionable'];

        return new self(
            new Uuid($transactionable['id']),
            $transactionable['provider'],
            new CustomerId($transactionable['provider_id']),
        );
    }
}
