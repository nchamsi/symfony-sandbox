<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Form\Handler;

use FOS\UserBundle\Form\Handler\RegistrationFormHandler as BaseHandler;

/**
 * This file is an adapted version of FOS User Bundle RegistrationFormHandler class.
 *
 *    (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 */
class RegistrationFormHandler extends \Sonata\UserBundle\Form\Handler\RegistrationFormHandler {

    /**
     * @param boolean $confirmation
     */
    public function process($confirmation = false) {
        $user = $this->createUser();
        $this->form->setData($user);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);
            /**
             * custom added code
             */
            $user->setUsername($user->getEmail());

            if ($this->form->isValid()) {
                $this->onSuccess($user, $confirmation);

                return true;
            }
        }

        return false;
    }

}
