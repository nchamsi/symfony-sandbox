<?php

namespace App\Event\User;

/**
 * Contains all events thrown in the FOSUserBundle
 */
class UserRegistrationConfirmedEvent extends \Symfony\Component\EventDispatcher\Event {

    const NAME = \FOS\UserBundle\FOSUserEvents::REGISTRATION_CONFIRMED;

    protected $user;

    public function __construct(\App\Entity\User\User $user) {
        $this->user = $user;
    }

    /**
     * 
     * @return \App\Entity\User\User
     */
    public function getUser() {
        return $this->user;
    }

}
