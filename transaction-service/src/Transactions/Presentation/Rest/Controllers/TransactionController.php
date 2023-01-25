<?php

namespace Src\Transactions\Presentation\Rest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Src\Transactionables\Application\Exceptions\InvalidTransactionableException as InvalidTransactionAppException;
use Src\Transactionables\Domain\Exceptions\InvalidTransactionableException;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;
use Src\Transactions\Application\ListTransactions;
use Src\Transactions\Application\StoreTransaction;
use Src\Transactions\Presentation\Exceptions\InvalidPayloadException;
use Src\Transactions\Presentation\Rest\Requests\ListTransactionsRequest;
use Src\Transactions\Presentation\Rest\Requests\StoreTransactionRequest as Request;
use Src\Transactions\Presentation\Rest\ViewModels\ListTransactionsViewModel;
use Src\Transactions\Presentation\Rest\ViewModels\StoreTransactionViewModel;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function list(
        ListTransactionsRequest $request,
        ListTransactions $listTransactions,
        ResponseFactory $response
    ): JsonResponse {
        try {
            $payload = ListTransactionsViewModel::fromRequest($request);

            $transactions = $listTransactions->paginated($payload);
        } catch (InvalidPayloadException $e) {
            return $response->json($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (TransactionableNotFoundException|InvalidTransactionAppException $e) {
            return $response->json($e->getMessage(), Response::HTTP_NOT_FOUND);
        }

        return $response->json([
            'transactions' => $transactions->items(),
            'per_page' => $transactions->perPage(),
            'page' => $transactions->currentPage(),
        ]);
    }

    public function store(
        Request $request,
        StoreTransaction $storeTransaction,
        ResponseFactory $response
    ): JsonResponse {
        $payload = StoreTransactionViewModel::fromRequest($request);

        try {
            $storeTransaction->handle($payload);
        } catch (InvalidTransactionableException|TransactionableNotFoundException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $response->json(['message' => 'Your transaction was sent, and sooner will be received.'], Response::HTTP_OK);
    }
}
