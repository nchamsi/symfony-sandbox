<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

/**
 * Class SonataRegistrationController.
 *
 * This class is inspired from the FOS RegistrationController
 *
 *
 * @author Hugo Briand <briand@ekino.com>
 */
class RegistrationFOSUser1Controller extends \Sonata\UserBundle\Controller\RegistrationFOSUser1Controller {

    /**
     * @return RedirectResponse
     */
    public function registerAction() {
        $user = $this->getUser();

        if ($user instanceof UserInterface) {
            $this->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');

            return $this->redirect($this->generateUrl('sonata_user_profile_show'));
        }

        $form = $this->get('sonata.user.registration.form');
        $formHandler = $this->get('sonata.user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();

            $authUser = false;
            if ($confirmationEnabled) {
                $this->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                $url = $this->generateUrl('fos_user_registration_check_email');
            } else {
                $authUser = true;
                $url = $this->generateUrl('sonata_user_profile_show');
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');

            $response = new RedirectResponse($url);

            if ($authUser) {
                //----------------------------------------------------------------
                /**
                 * custom added code - add event for registration confirmed action
                 */
                $this->dispatchUserRegistrationConfirmedEvent($user);
                //----------------------------------------------------------------
                $this->authenticateUser($user, $response);
            }

            return $response;
        }

        $this->get('session')->set('sonata_user_redirect_url', $this->get('request')->headers->get('referer'));

        return $this->render('FOSUserBundle:Registration:register.html.' . $this->getEngine(), array(
                    'form' => $form->createView(),
        ));
    }

    public function confirmAction($token) {

        $user = $this->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->get('fos_user.user_manager')->updateUser($user);

        //----------------------------------------------------------------
        /**
         * custom added code - add event for registration confirmed action
         */
        $this->dispatchUserRegistrationConfirmedEvent($user);
        //----------------------------------------------------------------

        if ($redirectRoute = $this->container->getParameter('sonata.user.register.confirm.redirect_route')) {
            $response = $this->redirect($this->generateUrl($redirectRoute, $this->container->getParameter('sonata.user.register.confirm.redirect_route_params')));
        } else {
            $response = $this->redirect($this->generateUrl('fos_user_registration_confirmed'));
        }

        $this->authenticateUser($user, $response);

        return $response;
    }

    /**
     * 
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     * @return boolean
     */
    protected function dispatchUserRegistrationConfirmedEvent($user) {
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $event = new \Application\Sonata\UserBundle\Event\UserRegistrationConfirmedEvent($user);
        $dispatcher->dispatch(\Application\Sonata\UserBundle\Event\UserRegistrationConfirmedEvent::NAME, $event);
        //----------------------------------------------------------------
        return true;
    }

}
