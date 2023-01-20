<?php

namespace Src\Presentation\Rest\Controllers;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthCheckController
{
    public function __invoke(): JsonResponse
    {
        return response()->json(Response::HTTP_OK);
    }
}
