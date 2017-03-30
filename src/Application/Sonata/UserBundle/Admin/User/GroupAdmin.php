<?php

namespace Application\Sonata\UserBundle\Admin\User;

use Sonata\UserBundle\Admin\Entity\GroupAdmin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class GroupAdmin extends BaseAdmin {

    protected $baseRoutePattern = 'user-group';
    protected $formOptions = array(
        'validation_groups' => array()
    );

    protected function configureRoutes(RouteCollection $collection) {
        $collection->clearExcept(array('list', 'create', 'edit', 'delete', /* 'show', 'history', 'history_compare_revisions', 'batch' */));
    }

    public function getExportFormats() {
        return array(
                //  'json', 'xml', 'csv', 'xls'
        );
    }

    /**
     * @deprecated since version number
     * @return type
     */
    public function getSecurityContext() {
        return $this->getConfigurationPool()->getContainer()
                        ->get('security.context');
    }

    /**
     * 
     * @return \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    public function getSecurityTokenStorage() {
        return $this->getConfigurationPool()->getContainer()
                        ->get('security.token_storage');
    }

    /**
     * 
     * @return \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    public function getSecurityAuthorizationChecker() {
        return $this->getConfigurationPool()->getContainer()
                        ->get('security.authorization_checker');
    }

    public function checkAccess($action, $object = null) {
        parent::checkAccess($action, $object);

        if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        if ($action == 'list' || $action == 'create' || is_null($object) || is_null($object->getId())) {
            return true;
        }

        if ($object && $object->getId()) {

            $query = $this->createQuery('list'); /* @var $query \Doctrine\ORM\QueryBuilder */
            $query->andWhere($query->getRootAlias() . '.id = :id')
                    ->setParameter('id', $object->getId());
            $result = $query->getQuery()->getOneOrNullResult();
            if ($result) {
                return true;
            } else {
                throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
            }
        }
        throw new \Symfony\Component\Security\Core\Exception\AccessDeniedException();
    }

    /**
     * 
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list') {
        $query = parent::createQuery($context);
        $query->leftJoin($query->getRootAlias() . '.owner', 'owner_');
        $query->addOrderBy('owner_.username', 'ASC');
        $query->addOrderBy($query->getRootAlias() . '.name', 'ASC');

        if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
            return $query;
        }


        $token = $this->getSecurityTokenStorage()->getToken();
        if ($token && $token->getUser()) {
            $query->andWhere($query->getRootAlias() . '.owner = :token_user_id')
                    ->setParameter('token_user_id', $token->getUser()->getId())
            ;
        }



        return $query;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        parent::configureDatagridFilters($datagridMapper);
        $datagridMapper->add('roles');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper) {

        parent::configureListFields($listMapper);

        unset($this->listModes['mosaic']);

        $listMapper->remove('batch');
        //$listMapper->remove('roles');
        //if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
        //    $listMapper->add('owner.username', null, array('label' => 'Owner'));
        //}

        $listMapper->add('_action', 'actions', array(
            'label' => 'Actions',
            'row_align' => 'right',
            'header_style' => 'width: 90px',
            'actions' => array(
                'show' => array(),
                'history' => array(),
                'edit' => array(),
                'delete' => array(),
            )
        ));
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object) {

        $errorElement
                ->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('name')))
                //->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('firstname', 'lastname')))
                //->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('lastname', 'firstname')))
                ->with('name')
                ->assertNotBlank()
                ->assertLength(array('min' => 5))
                ->end()
        ;
    }

    public function prePersist($object) { /* @var $object \Symfony\Component\Security\Core\User\UserInterface */
        parent::prePersist($object);

        //$token = $this->getSecurityTokenStorage()->getToken();
        //if (!is_null($token) && !is_null($token->getUser())) {
        //    $object->setOwner($token->getUser());
        //}
    }

}
