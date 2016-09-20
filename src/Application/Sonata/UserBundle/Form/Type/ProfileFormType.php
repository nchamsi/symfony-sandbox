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

class ProfileFormType extends \Sonata\UserBundle\Form\Type\ProfileType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('media', 'sonata_media_type', array(
            'label' => 'Image', 'required' => false,
            'provider' => 'sonata.media.provider.image',
            'context' => 'users'));
        parent::buildForm($builder, $options);
    }

    public function getName() {
        return 'application_sonata_user_profile';
    }

}
