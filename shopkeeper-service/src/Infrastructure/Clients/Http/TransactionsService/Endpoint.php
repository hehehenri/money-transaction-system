<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService;

use Psr\Http\Message\ResponseInterface as GuzzleResponse;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetBalanceResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetTransactionsResponse\GetTransactionsResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\RegisterShopkeeperResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\Response;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\SendTransactionResponse;

enum Endpoint: string
{
    case REGISTER_ShopkeeperS = '/transactionable/register';
    case GET_BALANCE = '/ledger';
    case GET_TRANSACTIONS = '/transaction';
    case SEND_TRANSACTION = '/transaciton';

    public function method(): Method
    {
        return match ($this) {
            self::SEND_TRANSACTION,
            self::REGISTER_ShopkeeperS => Method::POST,
            self::GET_BALANCE,
            self::GET_TRANSACTIONS => Method::GET,
        };
    }

    public function deserializeResponse(GuzzleResponse $response): Response
    {
        return match ($this) {
            self::REGISTER_ShopkeeperS => RegisterShopkeeperResponse::deserialize($response),
            self::GET_BALANCE => GetBalanceResponse::deserialize($response),
            self::GET_TRANSACTIONS => GetTransactionsResponse::deserialize($response),
            self::SEND_TRANSACTION => SendTransactionResponse::deserialize($response)
        };
    }
}
