<?php

namespace Src\Transactions\Application;

use Src\Infrastructure\Clients\AuthorizerClient;
use Src\Infrastructure\Clients\Exceptions\InvalidURIException;
use Src\Infrastructure\Clients\Exceptions\RequestException;
use Src\Transactions\Domain\Entities\Transaction;

class AuthorizeTransaction
{
    public function __construct(private readonly AuthorizerClient $client)
    {
    }

    /**
     * @throws RequestException
     * @throws InvalidURIException
     */
    public function handle(Transaction $transaction): bool
    {
        $this->client->authorize();

        return false;
    }
}
