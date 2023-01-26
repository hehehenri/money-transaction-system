<?php

namespace Src\Transactionables\Presentation\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Src\Transactionables\Application\RegisterTransactionable;
use Src\Transactionables\Domain\ViewModels\RegisterTransactionableViewModel;
use Src\Transactionables\Presentation\FormRequests\RegisterTransactionableRequest;
use Symfony\Component\HttpFoundation\Response;

class TransactionableController
{
    public function register(RegisterTransactionableRequest $request, RegisterTransactionable $register, ResponseFactory $response): JsonResponse
    {
        /** @var array<string, string> $payload */
        $payload = $request->validated();

        $viewModel = RegisterTransactionableViewModel::jsonSerialize($payload);

        $transactionable = $register->handle($viewModel);

        return $response->json(['transactionable' => $transactionable->jsonSerialize()], Response::HTTP_CREATED);
    }
}
