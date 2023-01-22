<?php

namespace Src\Customer\Presentation\Rest\Controllers;

use Illuminate\Http\JsonResponse;
use Src\Customer\Presentation\Rest\Requests\RegisterRequest;
use Src\Customer\Presentation\Rest\ViewModels\RegisterViewModel;
use Src\User\Domain\Exceptions\InvalidParameterException;
use Symfony\Component\HttpFoundation\Response;

class CustomerController
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $payload = RegisterViewModel::fromRequest($request->validated());
        } catch (InvalidParameterException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


    }
}
