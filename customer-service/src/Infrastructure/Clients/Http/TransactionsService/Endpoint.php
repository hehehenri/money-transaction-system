<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService;

use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Src\Infrastructure\Clients\Http\Enums\Method;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetBalanceResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\RegisterCustomerResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\Response;
use Src\Infrastructure\Events\ValueObjects\Payloads\EventPayload;

enum Endpoint: string
{
    case REGISTER_CUSTOMERS = '/transactionable/register';
    case GET_BALANCE = '/ledger';

    public function method(): Method
    {
        return match ($this) {
            self::REGISTER_CUSTOMERS => Method::POST,
            self::GET_BALANCE => Method::GET,
        };
    }

    public function deserializeResponse(GuzzleResponse $response): Response
    {
        return match ($this) {
            self::REGISTER_CUSTOMERS => RegisterCustomerResponse::deserialize($response),
            self::GET_BALANCE => GetBalanceResponse::deserialize($response),
        };
    }
}
