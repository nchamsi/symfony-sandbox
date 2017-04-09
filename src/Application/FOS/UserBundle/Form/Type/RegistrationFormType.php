<?php

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\FOS\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationFormType extends \Sonata\UserBundle\Form\Type\RegistrationFormType
{
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'application_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('firstname', 'text', array_merge(array(
                    'label' => 'form.label_firstname',
                    'translation_domain' => 'SonataUserBundle',
                                ), $this->mergeOptions))
                ->add('lastname', 'text', array_merge(array(
                    'label' => 'form.label_lastname',
                    'translation_domain' => 'SonataUserBundle',
                                ), $this->mergeOptions))
        ;
        parent::buildForm($builder, $options);

        $builder
                ->remove('username')
                ->add('username', 'hidden', array_merge(array(
                    'label' => 'form.label_username',
                    'translation_domain' => 'SonataUserBundle',
                                ), $this->mergeOptions))
                ;
        
        $builder->add('captcha', 'Gregwar\CaptchaBundle\Type\CaptchaType', array(
            'as_url' => true,
            'reload' => true,
            'translation_domain'=>'GregwarCaptchaBundle'
            ));
        
    }


}
