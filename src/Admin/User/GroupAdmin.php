<?php

namespace App\Admin\User;

use Sonata\UserBundle\Admin\Entity\GroupAdmin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class GroupAdmin extends BaseAdmin
{

    protected $baseRoutePattern = 'security/users/groups';

    protected $formOptions = array(
        'validation_groups' => array()
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create', 'edit', 'delete', /* 'show', 'history', 'history_compare_revisions', 'batch' */));
    }

    public function getExportFormats()
    {
        return array(//  'json', 'xml', 'csv', 'xls'
        );
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper):void
    {
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper->add('roles');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper):void
    {
        parent::configureListFields($listMapper);

        unset($this->listModes['mosaic']);

        $listMapper->remove('batch');
        //$listMapper->remove('roles');
        //if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
        //    $listMapper->add('owner.username', null, array('label' => 'Context'));
        //}

        $listMapper->add('_action', 'actions', array(
            'label' => 'Actions',
            'row_align' => 'right',
            'header_style' => 'width: 90px',
            'actions' => array(
                'show' => array(),
                //'history' => array(),
                'edit' => array(),
                'delete' => array(),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper):void
    {
        // NEXT_MAJOR: Keep FQCN when bumping Symfony requirement to 2.8+.
        $securityRolesType = method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')
            ? 'Sonata\UserBundle\Form\Type\SecurityRolesType'
            : 'sonata_security_roles';

        $formMapper
            ->tab('Group')
            ->with('General', array('class' => 'col-md-6'))
            ->add('name')
            ->end()
            ->end()
            ->tab('Security')
            ->with('Roles', array('class' => 'col-md-12'))
            ->add('roles', $securityRolesType, array(
                'expanded' => true,
                'multiple' => true,
                'required' => false,
            ))
            ->end()
            ->end();
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {

        $errorElement
            ->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('name')))
            //->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('firstname', 'lastname')))
            //->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('lastname', 'firstname')))
            ->with('name')
            //->assertNotBlank()
            //->assertLength(array('min' => 5))
            ->end();
    }

    public function prePersist($object)
    {
        /* @var $object \Symfony\Component\Security\Core\User\UserInterface */
        parent::prePersist($object);

        //$token = $this->getSecurityTokenStorage()->getToken();
        //if (!is_null($token) && !is_null($token->getUser())) {
        //    $object->setOwner($token->getUser());
        //}
    }

}
