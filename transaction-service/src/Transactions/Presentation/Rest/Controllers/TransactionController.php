<?php

namespace Src\Transactions\Presentation\Rest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Src\Transactions\Application\StoreTransaction;
use Src\Transactions\Presentation\Rest\Requests\StoreTransactionRequest as Request;
use Src\Transactions\Presentation\Rest\ViewModels\StoreTransactionViewModel;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    public function store(
        Request $request,
        StoreTransaction $storeTransaction,
        ResponseFactory $response
    ): JsonResponse {
        $payload = StoreTransactionViewModel::fromRequest($request);

        $storeTransaction->handle($payload);

        return $response->json(['message' => 'Your transaction was sent, and sooner will be received.'], Response::HTTP_OK);
    }
}
