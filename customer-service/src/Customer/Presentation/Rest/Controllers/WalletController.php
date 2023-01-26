<?php

namespace Src\Customer\Presentation\Rest\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Src\Customer\Domain\Entities\Customer;
use Src\Infrastructure\Clients\Http\Exceptions\ExternalServiceException;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ClientException;
use Src\Infrastructure\Clients\Http\TransactionsService\Exceptions\ResourceNotFoundException;
use Src\Transaction\Application\GetBalance;
use Src\Transaction\Application\GetTransactions;
use Symfony\Component\HttpFoundation\Response;

class WalletController
{
    public function balance(Request $request, GetBalance $getBalance, ResponseFactory $response): JsonResponse
    {
        /** @var Customer $customer */
        $customer = $request->user();

        try {
            $balance = $getBalance->for($customer);
        } catch (ExternalServiceException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
        } catch (ClientException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ResourceNotFoundException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $response->json(['balance' => $balance->amount->value()]);
    }

    public function transactions(
        Request $request,
        GetTransactions $getTransactions,
        ResponseFactory $response
    ): JsonResponse {
        /** @var Customer $customer */
        $customer = $request->user();

        try {
            $transactionsResponse = $getTransactions->for($customer);
        } catch (ExternalServiceException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_SERVICE_UNAVAILABLE);
        } catch (ClientException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->json($transactionsResponse->serialize());
    }
}
