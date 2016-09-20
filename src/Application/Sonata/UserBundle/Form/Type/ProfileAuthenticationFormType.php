<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Form\Type;

use Application\Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileAuthenticationFormType extends \FOS\UserBundle\Form\Type\ProfileFormType {

    public function getName() {
        return 'application_sonata_user_profile_authentication';
    }

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', null, array('label' => 'form.username', 'disabled' => true, 'translation_domain' => 'FOSUserBundle'))
                ->add('email', 'email', array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
        ;
    }

}
