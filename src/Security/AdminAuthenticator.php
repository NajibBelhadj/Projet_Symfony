<?php

namespace App\Security;

use App\Entity\Candidat;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AdminAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app1_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request)
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        $roles = $user->getRoles();
        if ($roles[0] != 'ROLE_ADMIN') {
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {


            $user = $this->entityManager->getRepository(User::class)->findAll();
            foreach ($user as $candidat) {
                if ($candidat->getRoles()[0] == 'ROLE_CANDIDAT') {
                    $date = $candidat->getDateOfAjout()->format('m/d/Y');
                    $final = date('m/d/Y', strtotime($date . ' + 3 month'));
                    $final = new DateTime($final);
                    $datenow = new \DateTime('now');
                    if (!$final > $datenow) {
                        $this->entityManager->remove($candidat);
                        $this->entityManager->flush();
                    }
                }
            }
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('admin_index'));
        throw new \Exception('TODO: provide a valid redirect inside ' . __FILE__);
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
