<?php

namespace Src\Shopkeeper\Presentation\Rest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\ResponseFactory;
use Src\Auth\Application\Exceptions\ShopkeeperValidationException;
use Src\Auth\Application\LoginShopkeeper;
use Src\Auth\Application\RegisterShopkeeper;
use Src\Auth\Domain\Exceptions\ShopkeeperValidationException as ShopkeeperAuthValidationException;
use Src\Auth\Domain\Exceptions\InvalidTokenException;
use Src\Shopkeeper\Domain\Exceptions\ShopkeeperRepositoryException;
use Src\Shopkeeper\Presentation\Rest\Requests\LoginRequest;
use Src\Shopkeeper\Presentation\Rest\Requests\RegisterRequest;
use Src\Shopkeeper\Presentation\Rest\ViewModels\Auth\LoginViewModel;
use Src\Shopkeeper\Presentation\Rest\ViewModels\RegisterViewModel;
use Src\Infrastructure\Exceptions\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, RegisterShopkeeper $registerShopkeeper, ResponseFactory $response): JsonResponse
    {
        try {
            $payload = RegisterViewModel::fromRequest($request);
        } catch (ShopkeeperAuthValidationException $e) {
            return $response->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $Shopkeeper = $registerShopkeeper->handle($payload);

        return $response->json(['Shopkeeper' => $Shopkeeper->jsonSerialize()], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request, LoginShopkeeper $login, ResponseFactory $response): JsonResponse
    {
        try {
            $payload = LoginViewModel::fromRequest($request);

            $token = $login->handle($payload);
        } catch (ShopkeeperValidationException|InvalidTokenException|ShopkeeperAuthValidationException $e) {
            return $response->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (AuthenticationException $e) {
            return $response->json(['error' => $e->getMessage()], HttpResponse::HTTP_UNAUTHORIZED);
        } catch (ShopkeeperRepositoryException) {
            return $response->json(['error' => 'Internal server error', HttpResponse::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return $response->json($token->jsonSerialize(), HttpResponse::HTTP_OK);
    }
}
