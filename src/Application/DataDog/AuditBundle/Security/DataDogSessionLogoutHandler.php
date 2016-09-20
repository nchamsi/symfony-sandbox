<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DataDog\AuditBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
//use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Handler for clearing invalidating the current session.
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
class DataDogSessionLogoutHandler implements LogoutHandlerInterface
{
    protected $security;
    
    protected $container;
    /**
     * Invalidate the current session.
     *
     * @param Request        $request
     * @param Response       $response
     * @param TokenInterface $token
     */
    
    public function __construct(SecurityContext $security, ContainerInterface $container) 
    {
        $this->security = $security;
        $this->container = $container;
    }
    
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        //$request->getSession()->invalidate();
    }
}
