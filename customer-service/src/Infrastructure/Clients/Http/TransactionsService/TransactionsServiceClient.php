<?php

namespace Src\Infrastructure\Clients\Http\TransactionsService;

use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use GuzzleHttp\Exception\GuzzleException;
use Src\Infrastructure\Clients\Http\BaseClient;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\Exceptions\InvalidURLException;
use Src\Infrastructure\Clients\Http\Exceptions\RequestException;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ClientException;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ResourceNotFoundException;
use Src\Infrastructure\Clients\Http\TransactionsService\Payloads\TransactionServicePayload;
use Src\Infrastructure\Clients\Http\TransactionsService\Responses\Response;
use Src\Infrastructure\Clients\Http\ValueObjects\URL;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class TransactionsServiceClient extends BaseClient
{
    /** @throws InvalidURLException */
    public function baseUrl(): URL
    {
        /** @var string $transactionsUrl */
        $transactionsUrl = config('services.transactions.base_url');

        return new URL($transactionsUrl);
    }

    /**
     * @throws ExternalServiceException
     * @throws GuzzleClientException
     * @throws ResourceNotFoundException
     * @throws GuzzleException
     * @throws ClientException
     */
    public function send(Endpoint $endpoint, TransactionServicePayload $payload): Response
    {
        try {
            $url = URL::build($endpoint, $this->baseUrl(), $payload);

            $response = parent::sendRequest($endpoint->method(), $url, $payload);
        } catch (GuzzleClientException $e) {
            if ($e->getCode() === HttpResponse::HTTP_NOT_FOUND) {
                throw ResourceNotFoundException::transactionableNotFound();
            }

            throw $e;
        } catch (RequestException|InvalidURLException $e) {
            throw ClientException::failedToCommunicateWithService($e);
        }

        return $endpoint->deserializeResponse($response);
    }

    public function serviceName(): string
    {
        /** @var string $serviceName */
        $serviceName = config('services.transactions.service_name');

        return $serviceName;
    }
}
