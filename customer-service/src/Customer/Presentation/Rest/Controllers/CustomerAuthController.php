<?php

namespace Src\Customer\Presentation\Rest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Src\Auth\Application\Exceptions\CustomerValidationException;
use Src\Auth\Application\LoginCustomer;
use Src\Auth\Application\RegisterCustomer;
use Src\Auth\Domain\Exceptions\CustomerValidationException as CustomerAuthValidationException;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Customer\Domain\Exceptions\CustomerRepositoryException;
use Src\Customer\Presentation\Rest\Requests\LoginRequest;
use Src\Customer\Presentation\Rest\Requests\RegisterRequest;
use Src\Customer\Presentation\Rest\ViewModels\Auth\LoginViewModel;
use Src\Customer\Presentation\Rest\ViewModels\RegisterViewModel;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class CustomerAuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterCustomer $registerCustomer, ResponseFactory $response): JsonResponse
    {
        try {
            $payload = RegisterViewModel::fromRequest($request);
        } catch (CustomerAuthValidationException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $customer = $registerCustomer->handle($payload);

        return $response->json(['customer' => $customer->jsonSerialize()], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request, LoginCustomer $login, ResponseFactory $response): JsonResponse
    {
        try {
            $payload = LoginViewModel::fromRequest($request);

            $token = $login->handle($payload);
        } catch (CustomerValidationException|InvalidTokenException|CustomerAuthValidationException $e) {
            return $response->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (AuthenticationException $e) {
            return $response->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        } catch (CustomerRepositoryException) {
            return $response->json(['error' => 'Internal server error', HttpResponse::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return $response->json($token->jsonSerialize(), HttpResponse::HTTP_OK);
    }
}
