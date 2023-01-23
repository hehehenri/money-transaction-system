<?php

namespace Src\Transaction\Presentation\Rest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Src\Transaction\Presentation\Rest\Requests\StoreTransactionRequest as Request;

class TransactionController extends Controller
{
    public function store(Request $request, ResponseFactory $response): JsonResponse
    {

    }
}
