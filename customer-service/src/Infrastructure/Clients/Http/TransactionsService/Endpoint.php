<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService;

use Psr\Http\Message\ResponseInterface as GuzzleResponse;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetBalanceResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetTransactionsResponse\GetTransactionsResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\RegisterCustomerResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\Response;

enum Endpoint: string
{
    case REGISTER_CUSTOMERS = '/transactionable/register';
    case GET_BALANCE = '/ledger';
    case GET_TRANSACTIONS = '/transaction';

    public function method(): Method
    {
        return match ($this) {
            self::REGISTER_CUSTOMERS => Method::POST,
            self::GET_BALANCE,
            self::GET_TRANSACTIONS => Method::GET,
        };
    }

    public function deserializeResponse(GuzzleResponse $response): Response
    {
        return match ($this) {
            self::REGISTER_CUSTOMERS => RegisterCustomerResponse::deserialize($response),
            self::GET_BALANCE => GetBalanceResponse::deserialize($response),
            self::GET_TRANSACTIONS => GetTransactionsResponse::deserialize($response),
        };
    }
}
