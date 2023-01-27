<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService\Responses;

use Psr\Http\Message\ResponseInterface;
use Src\Customer\Domain\ValueObjects\CustomerId;
use Src\Shared\ValueObjects\Uuid;

class RegisterCustomerResponse implements Response
{
    public function __construct(
        public readonly Uuid $id,
        public readonly string $provider,
        public readonly CustomerId $providerId
    ) {
    }

    public static function deserialize(ResponseInterface $jsonResponse): self
    {
        /** @var array<string, array<string, string>> $response */
        $response = json_decode($jsonResponse->getBody(), true);

        $transactionable = $response['transactionable'];

        return new self(
            new Uuid($transactionable['id']),
            $transactionable['provider'],
            new CustomerId($transactionable['provider_id']),
        );
    }
}
