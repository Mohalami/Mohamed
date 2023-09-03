<?php

namespace App\Security;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordHasher;

    public function __construct(UrlGeneratorInterface $urlGenerator,
                                EntityManagerInterface $entityManager,
                                CsrfTokenManagerInterface $csrfTokenManager,
                                UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager= $entityManager;
        $this->urlGenerator= $urlGenerator;
        $this->csrfTokenManager= $csrfTokenManager;
        $this->passwordHasher= $passwordHasher;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
        {
            // Check if the user has the "admin" role
            if ($token->getUser() && in_array('ROLE_ADMIN', $token->getUser()->getRoles(), true)) {
                // Redirect the admin user to the admin page
                return new RedirectResponse($this->urlGenerator->generate('admin')); 
            }

            // For non-admin users or if no specific redirect is defined for admin users
            if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
                return new RedirectResponse($targetPath);
            }

            // Handle other cases here or throw an exception if needed
            throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        }


    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
