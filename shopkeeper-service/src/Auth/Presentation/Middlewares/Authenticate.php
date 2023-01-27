<?php

namespace Src\Auth\Presentation\Middlewares;

use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Auth\Domain\Exceptions\ShopkeeperValidationException;
use Src\Shopkeeper\Application\GetShopkeeper;
use Src\Shopkeeper\Domain\ValueObjects\Email;
use Src\Infrastructure\Auth\JWTToken;
use Src\Infrastructure\Exceptions\InvalidShopkeeperException;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly GetShopkeeper $getShopkeeper
    ) {
    }

    public function handle(Request $request, Closure $next): Closure|JsonResponse
    {
        /** @var string $tokenHeader */
        $tokenHeader = $request->header('Authorization');

        if (! $tokenHeader) {
            return $this->response->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $token = JWTToken::decode($tokenHeader);

        try {
            $email = new Email($token['email']);

            $Shopkeeper = $this->getShopkeeper->byEmail($email);
        } catch (InvalidShopkeeperException|ShopkeeperValidationException) {
            return $this->response->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $request->setUserResolver(fn () => $Shopkeeper);

        return $next($request);
    }
}
