<?php

namespace Src\Transaction\Application;

use GuzzleHttp\Exception\GuzzleException;
use Src\Customer\Domain\Entities\Customer;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\Exceptions\InvalidURLException;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\TransactionsService\Endpoint;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ClientException;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ResourceNotFoundException;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\GetBalancePayload;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\GetBalanceResponse;
use Src\Infrastructure\Clients\Http\TransactionsService\TransactionsServiceClient;
use Src\Transaction\Domain\ValueObjects\Balance;
use Symfony\Component\HttpFoundation\Response;

class GetBalance
{
    public function __construct(private readonly TransactionsServiceClient $client)
    {
    }

    /**
     * @throws ResourceNotFoundException
     * @throws ExternalServiceException
     * @throws ClientException
     * @throws GuzzleException
     */
    public function for(Customer $customer): Balance
    {
        $payload = new GetBalancePayload($customer->id);

        try {
            /** @var GetBalanceResponse $response */
            $response = $this->client->send(Endpoint::GET_BALANCE, $payload);
        } catch (GuzzleException $e) {
            if ($e->getCode() === Response::HTTP_NOT_FOUND) {
                throw ResourceNotFoundException::balanceNotFound($customer->id);
            }
            throw $e;
        } catch (RequestException|InvalidURLException $e) {
            throw ClientException::failedToCommunicateWithService($e);
        }

        return new Balance($response->balance, $customer);
    }
}
