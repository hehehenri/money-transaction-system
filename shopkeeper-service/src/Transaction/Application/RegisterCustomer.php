<?php

namespace Src\Transaction\Application;

use Src\Shopkeeper\Domain\Entities\Shopkeeper;
use Src\Infrastructure\Clients\Http\Exceptions\InvalidURLException;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\Exceptions\ResponseException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\RegisterShopkeeperPayload;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;

class RegisterShopkeeper
{
    public function __construct(private readonly TransactionsServiceClient $client)
    {
    }

    /**
     * @throws RequestException
     * @throws ResponseException
     * @throws InvalidURLException
     */
    public function intoTransactionsService(Shopkeeper $Shopkeeper): void
    {
        $payload = new RegisterShopkeeperPayload($Shopkeeper->id);

        $this->client->send(Endpoint::REGISTER_ShopkeeperS, $payload);
    }
}
