<?php

namespace Src\Customer\Presentation\Rest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\Customer\Application\Exceptions\InvalidParameterException as CustomerApplicationParameterException;
use Src\Customer\Application\LoginCustomer;
use Src\Customer\Presentation\Rest\Requests\LoginRequest;
use Src\Customer\Presentation\Rest\ViewModels\Auth\LoginViewModel;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Src\User\Domain\Exceptions\InvalidParameterException as UserDomainParameterException;
use Symfony\Component\HttpFoundation\Response;

class CustomerAuthController extends Controller
{
    public function login(LoginRequest $request, LoginCustomer $login): JsonResponse
    {
        try {
            $payload = LoginViewModel::fromRequest($request->validated());

            $token = $login->handle($payload);
        } catch (UserDomainParameterException|CustomerApplicationParameterException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (AuthenticationException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['token' => (string) $token], Response::HTTP_OK);
    }
}
