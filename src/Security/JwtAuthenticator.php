<?php
namespace App\Security;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtAuthenticator extends AbstractGuardAuthenticator
{
    private $em;
    private $params;

    public function __construct(EntityManagerInterface $em, ContainerBagInterface $params)
    {
        $this->em = $em;
        $this->params = $params;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [ 
            'message' => 'Authentication Required'
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function supports(Request $request)
    {
        return $request->headers->has('x-access-token');
    }

    public function getCredentials(Request $request)
    {
        return $request->headers->get('x-access-token');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        try {
            $jwt = (array) JWT::decode(
                              $credentials, 
                              $this->params->get('jwt_secret'),
                              ['HS256']
                            );
            return $this->em->getRepository(User::class)
                    ->findOneBy([
                            'id' => $jwt['id'],
                    ]);
        }catch (\Exception $exception) {
                throw new AuthenticationException($exception->getMessage());
        }
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return $user != null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
                'message' => $exception->getMessage()
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {
        $request->attributes->set('roles', $token->getRoleNames());
        $request->attributes->set('user', $token->getUser());

        
        $isAdmin = false;
        $string = 'ROLE_ADMIN';
        foreach ($token->getRoleNames() as $role) {
            //if (strstr($string, $url)) { // mine version
            if (strpos($string, $role) !== FALSE) { // Yoshi version
                $isAdmin = true;
            }
        }
        
        return;
    }

    public function supportsRememberMe()
    {
        return false;
    }
}
