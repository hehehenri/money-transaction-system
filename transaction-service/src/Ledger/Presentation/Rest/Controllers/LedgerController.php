<?php

namespace Src\Ledger\Presentation\Rest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Src\Ledger\Application\Exceptions\InvalidLedger;
use Src\Ledger\Application\GetLedger;
use Src\Ledger\Presentation\Exceptions\InvalidPayload;
use Src\Ledger\Presentation\Rest\Requests\ShowRequest;
use Src\Ledger\Presentation\Rest\ViewModels\ShowLedgerViewModel;
use Src\Transactionables\Domain\Exceptions\TransactionableNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class LedgerController extends Controller
{
    public function show(ShowRequest $request, GetLedger $getLedger, ResponseFactory $response): JsonResponse
    {
        try {
            $payload = ShowLedgerViewModel::fromRequest($request);

            $ledger = $getLedger->byTransactionable($payload);
        } catch (InvalidPayload|InvalidLedger $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (TransactionableNotFoundException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return $response->json(['ledger' => $ledger->jsonSerialize()]);
    }
}
