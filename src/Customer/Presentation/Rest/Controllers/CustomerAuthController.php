<?php

namespace Src\Customer\Presentation\Rest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Src\Customer\Application\Exceptions\InvalidParameterException as CustomerApplicationParameterException;
use Src\Customer\Application\LoginCustomer;
use Src\Customer\Presentation\Rest\Requests\LoginRequest;
use Src\Customer\Presentation\Rest\ViewModels\Auth\LoginViewModel;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Src\User\Domain\Exceptions\InvalidParameterException as UserDomainParameterException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class CustomerAuthController extends Controller
{
    public function login(LoginRequest $request, LoginCustomer $login, ResponseFactory $response): JsonResponse
    {
        try {
            $payload = LoginViewModel::fromRequest($request);

            $token = $login->handle($payload);
        } catch (UserDomainParameterException|CustomerApplicationParameterException $e) {
            return $response->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (AuthenticationException $e) {
            return $response->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        }

        return $response->json(['token' => (string) $token], HttpResponse::HTTP_OK);
    }
}
