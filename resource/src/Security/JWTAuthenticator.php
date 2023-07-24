<?php

namespace App\Security;

use App\JWT\JWTValidatorInterface;
use App\TokenExtraction\ExtractTokenInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class JWTAuthenticator extends AbstractAuthenticator
{
    public function __construct(
        private readonly ExtractTokenInterface $tokenExtractor,
        private readonly JWTValidatorInterface $JWTValidator,
    ) {
    }

    public function supports(Request $request): ?bool
    {
        return false !== $this->tokenExtractor->extract($request);
    }

    /**
     * @inheritDoc
     */
    public function authenticate(Request $request): Passport
    {
        $jwtToken = $this->tokenExtractor->extract($request);
        if (false === $jwtToken) {
            throw new AuthenticationException('no jwt');
        }
        try {
            $data = $this->JWTValidator->validate($jwtToken);
            $passport = new SelfValidatingPassport(
                new UserBadge(
                    $data['sub'],
                    function ($id) use ($data) {
                        return new ClientUser($id, $data);
                    }
                )
            );

            return $passport;
        } catch (\Exception $e) {
            throw new AuthenticationException($e->getMessage());
        }
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(
            ['error' => $exception->getMessage()],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
