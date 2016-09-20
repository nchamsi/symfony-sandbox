<?php

namespace Application\Sonata\UserBundle\Event;

/**
 * Contains all events thrown in the FOSUserBundle
 */
class UserRegistrationConfirmedEvent extends \Symfony\Component\EventDispatcher\Event {

    const NAME = FOSUserEvents::REGISTRATION_CONFIRMED;

    protected $user;

    public function __construct(\Application\Sonata\UserBundle\Entity\User\User $user) {
        $this->user = $user;
    }

    /**
     * 
     * @return \Application\Sonata\UserBundle\Entity\User\User
     */
    public function getUser() {
        return $this->user;
    }

}
