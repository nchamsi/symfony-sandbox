<?php

namespace AppBundle\Admin\User;

use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use FOS\UserBundle\Model\UserManagerInterface;
use Sonata\AdminBundle\Route\RouteCollection;

class UserAdmin extends BaseAdmin
{

    protected $baseRoutePattern = 'user-user';
    protected $datagridValues = array(
        '_page' => 1, // Display the first page (default = 1)
        '_sort_order' => 'ASC', // Descendant ordering (default = 'ASC')
        '_sort_by' => 'username' // name of the ordered field (default = the model id field, if any)
    );
    protected $formOptions = array(
        'validation_groups' => array()
    );

    /**
     * @deprecated since version number
     * @return type
     */
    public function getSecurityContext()
    {
        return $this->getConfigurationPool()->getContainer()
            ->get('security.context');
    }

    /**
     *
     * @return \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    public function getSecurityTokenStorage()
    {
        return $this->getConfigurationPool()->getContainer()
            ->get('security.token_storage');
    }

    /**
     *
     * @return \Symfony\Component\Security\Core\Authorization\AuthorizationChecker
     */
    public function getSecurityAuthorizationChecker()
    {
        return $this->getConfigurationPool()->getContainer()
            ->get('security.authorization_checker');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create', 'edit', 'show', 'delete', /* 'history', 'history_compare_revisions', 'batch' */));
    }

    public function getExportFormats()
    {
        return array(// 'json', 'xml', 'csv', 'xls'
        );
    }

    public function getFormBuilder()
    {

        $this->formOptions['data_class'] = $this->getClass();

        $formBuilder = $this->getFormContractor()->getFormBuilder(
            $this->getUniqid(), $this->formOptions
        );

        $this->defineFormBuilder($formBuilder);

        return $formBuilder;
    }

    protected function getUserMediaContextId()
    {

        $context = $this->getConfigurationPool()->getContainer()->get('doctrine')
            ->getRepository('AppBundle:Classification\Context')
            ->find('users');

        if (is_null($context)) {
            $context = new \AppBundle\Entity\Classification\Context();
            $context->setId('users');
            $context->setName('users');
            $context->setEnabled(true);
            $context->setCreatedAt(new \Datetime());
            $context->setUpdatedAt(new \Datetime());
            $this->getConfigurationPool()->getContainer()->get('doctrine.orm.default_entity_manager')->persist($context);
            $this->getConfigurationPool()->getContainer()->get('doctrine.orm.default_entity_manager')->flush($context);

            $defaultCategory = new \AppBundle\Entity\Classification\Category();
            $defaultCategory->setContext($context);
            $defaultCategory->setName('users');
            $defaultCategory->setEnabled(true);
            $defaultCategory->setCreatedAt(new \Datetime());
            $defaultCategory->setUpdatedAt(new \Datetime());
            $defaultCategory->setSlug('users');
            $defaultCategory->setDescription('users');
            $this->getConfigurationPool()->getContainer()->get('doctrine.orm.default_entity_manager')->persist($defaultCategory);
            $this->getConfigurationPool()->getContainer()->get('doctrine.orm.default_entity_manager')->flush($defaultCategory);
        }

        return $context->getId();
    }

    public function checkAccess2($action, $object = null)
    {
        parent::checkAccess($action, $object);

        if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        if ($action == 'list' || $action == 'create' || is_null($object) || is_null($object->getId())) {
            return true;
        }
        $token = $this->getSecurityTokenStorage()->getToken();
        if (($action == 'edit' || $action == 'show') && $this->getSubject() && $this->getSubject()->getId() == $token->getUser()->getId()) { // user can edit is own profile
            return true;
        }
        if ($object && $object->getId()) {
            $query = $this->createQuery('list');
            /* @var $query \Doctrine\ORM\QueryBuilder */
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
    public function createQuery2($context = 'list')
    {
        $query = parent::createQuery($context);

        $query->leftJoin($query->getRootAlias() . '.owner', 'owner_');
        $query->addOrderBy('owner_.username', 'ASC');
        $query->addOrderBy($query->getRootAlias() . '.username', 'ASC');

        if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
            return $query;
        }

        $token = $this->getSecurityTokenStorage()->getToken();
        if ($token && $token->getUser()) {
            $query->andWhere($query->getRootAlias() . '.id = :token_user_id OR ' . $query->getRootAlias() . '.owner = :token_user_id')
                ->setParameter('token_user_id', $token->getUser()->getId());
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {

        parent::configureDatagridFilters($filterMapper);

        $filterMapper
            ->remove('id')
            ->remove('locked')
            ->add('enabled')//->add('locked')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper->addIdentifier('media', 'media_thumbnail', array(
            'label' => 'Image',
            'width' => '30',
            'height' => '30',
            'class' => 'img-polaroid',
        ));

        parent::configureListFields($listMapper);

        unset($this->listModes['mosaic']);

        $listMapper
            ->remove('batch')
            ->remove('impersonating')
            ->remove('groups')
            ->remove('enabled')
            //->remove('locked')
            ->remove('createdAt')
            ->add('groups', null, array('route' => array('name' => '_')))
            ->add('createdAt', null, array('pattern' => 'Y-MM-dd H:mm:ss'))
            ->add('enabled', null, array('editable' => true,
                'row_align' => 'center',
                'header_style' => 'width: 100px',
            ));

        //if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
        //    $listMapper
        //            ->add('owner.username', null, array('label' => 'Context'));
        //}

        $listMapper
            ->add('_action', 'actions', array(
                'label' => 'Actions',
                'row_align' => 'right',
                'header_style' => 'width: 115px',
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
    protected function configureFormFields(FormMapper $formMapper)
    {

        // define group zoning

        $formMapper
            ->tab('User')
            ->with('Username', array('class' => 'col-md-6'))
            ->add('username', null, array(
                'disabled' => (!$this->getSecurityAuthorizationChecker()->isGranted('ROLE_ADMIN'))
            ))
            ->add('email')
            ->end()
            ->with('Change Password', array('class' => 'col-md-6'))
            ->add('plainPassword', 'repeated', array(
                'required' => false,
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => (!$this->getSubject() || is_null($this->getSubject()->getId())),
                'first_options' => array('label' => $this->trans('Password')),
                'second_options' => array('label' => $this->trans('Confirm Password')),
            ))
            ->end()
            ->end();

        $formMapper
            ->tab('Profile')
            ->with('Personal Information', array('class' => 'col-md-5'))
            ->add('firstname', null, array('required' => true))
            ->add('lastname', null, array('required' => true))
            ->add('phone', null, array('required' => false))
            ->add('dateOfBirth', 'sonata_type_date_picker', array(
                //'read_only' => true,
                'dp_min_date' => '01/01/1900',
                'format' => 'dd/MM/yyyy',
                'dp_default_date' => (new \DateTime())->format('d/m/Y'),
                'dp_max_date' => (new \DateTime())->format('d/m/Y'),
                //'dp_default_date'=> (new \DateTime())->sub(new \DateInterval('P15Y'))->format('d/m/Y')
                //'dp_max_date'=> (new \DateTime())->sub(new \DateInterval('P15Y'))->format('d/m/Y'),
                'required' => false,
            ))
            //->add('website', 'url', array('required' => false))
            //->add('biography', 'text', array('required' => false))
            ->add('gender', 'sonata_user_gender', array(
                'required' => true,
                'translation_domain' => $this->getTranslationDomain(),
            ))
            ->add('locale', 'locale', array('required' => false))
            //->add('timezone', 'timezone', array('required' => false))
            ->end()
            ->with('Image', array('class' => 'col-md-7'))
            ->add('media', 'sonata_media_type',
                array('label' => false, 'required' => false,
                    'provider' => 'sonata.media.provider.image',
                    'context' => $this->getUserMediaContextId()
                )
            )
            ->end()
            ->end();

        if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_ADMIN')) {
            $formMapper
                ->tab('Security')
                ->with('Status', array('class' => 'col-md-4'))->end()
                ->with('Groups', array('class' => 'col-md-8'))->end()
                ->end();
        }

        if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_ADMIN')) {
            $formMapper
                ->tab('Security')
                ->with('Status')
                //->add('locked', null, array('required' => false))
                //->add('expired', null, array('required' => false))
                ->add('enabled', null, array('required' => false))
                //->add('credentialsExpired', null, array('required' => false))
                ->end()
                ->with('Groups')
                ->add('groups', 'sonata_type_model', array(
                    'label' => false,
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'btn_add' => false
                ))
                ->end()
                ->end();
        }

    }

    protected function configureShowFields(ShowMapper $showMapper)
    {

        $showMapper
            ->with('User')
            ->add('username')
            ->add('email')
            ->end()
            ->with('Profile')
            //->add('media',null,array('label'=>'Image'))
            ->add('firstname')
            ->add('lastname')
            ->add('phone')
            ->add('dateOfBirth')
            //->add('website')
            //->add('biography')
            ->add('gender')
            ->add('locale')
            //->add('timezone')
            ->end()
            /*
              ->with('Social')
              ->add('facebookUid')
              ->add('facebookName')
              ->add('twitterUid')
              ->add('twitterName')
              ->add('gplusUid')
              ->add('gplusName')
              ->end()
             */
            ->end();

        if ($this->getSecurityAuthorizationChecker()->isGranted('ROLE_ADMIN')) {
            $showMapper
                ->with('Security Status')
                //->add('locked')
                //->add('expired')
                ->add('enabled')
                //->add('credentialsExpired')
                ->end()
                ->with('Security Groups')
                ->add('groups')
                ->end();
        }
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'show':
                return "AppBundle:Admin:User/show.html.twig";
            case 'edit':
                if (!$this->getSecurityAuthorizationChecker()->isGranted('ROLE_SUPER_ADMIN')) {
                    return "AppBundle:Admin:User/edit.html.twig";
                }
                break;
        }
        return parent::getTemplate($name);
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {

        $errorElement
            ->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('username')))
            ->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('email')))
            //->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('firstname', 'lastname')))
            //->addConstraint(new \Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity(array('lastname', 'firstname')))
            ->with('username')
            ->assertNotBlank()
            ->assertLength(array('min' => 3))
            ->end()
            ->with('email')
            ->assertNotBlank()
            ->assertEmail()
            ->end()
            ->with('plainPassword')
            ->assertLength(array('min' => 1))
            ->end()
            ->with('firstname')
            ->assertNotBlank()
            ->end()
            ->end()
            ->with('lastname')
            ->assertNotBlank()
            ->end();
    }

    public function prePersist($object)
    {
        /* @var $object \Symfony\Component\Security\Core\User\UserInterface */
        parent::prePersist($object);

        //$token = $this->getSecurityTokenStorage()->getToken();
        //if (!is_null($token->getUser()) && !is_null($token->getUser()->getId())) {
        //    $object->setOwner($token->getUser());
        //}
    }

}
