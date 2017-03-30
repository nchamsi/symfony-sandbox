<?php

namespace Application\DataDog\AuditBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin as Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AuditLogAdmin extends Admin {

    protected $baseRoutePattern = 'audit/datadog-audit';
    protected $datagridValues = array(
        '_page' => 1, // Display the first page (default = 1)
        '_sort_order' => 'DESC', // Descendant ordering (default = 'ASC')
        '_sort_by' => 'loggedAt' // name of the ordered field (default = the model id field, if any)
    );

    protected function configureRoutes(RouteCollection $collection) {
        $collection->clearExcept(array('list', 'show', /* 'export','delete' */));
    }

    public function getExportFormats() {
        return array(
                // 'json', 'xml', 'csv', 'xls'
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb = $em->createQueryBuilder();
        $qb = $qb->select('u')
                ->from($this->getClass(), 'u')
        //->innerJoin('u.blame','p')
        //->groupBy('u.ip')
        ;

        /* $qb = $qb->add('select', 'u')
          ->add('from', 'YourBundleFile\YourBundleFileBundle\Entity\YourEntity u');
         */
        $query = $qb->getQuery();
        $arrayType = $query->getResult();
        //$ips = array();
        //foreach ($arrayType as $a) {
        //    $ips[$a->getIp()] = $a->getIp();
        //}

        $datagridMapper
                ->add('created_at_start', 'doctrine_orm_callback', array(
                    'field_type' => 'sonata_type_date_picker',
                    'field_options' => array(
                        'format' => 'dd-MM-yyyy',
                        'dp_min_date' => '1/1/2016',
                        'dp_use_current' => false
                    ),
                    'callback' => array($this, 'filterByDateStart')
                ))
                ->add('created_at_end', 'doctrine_orm_callback', array(
                    'field_type' => 'sonata_type_date_picker',
                    'field_options' => array(
                        'format' => 'dd-MM-yyyy',
                        'dp_min_date' => '1/1/2016',
                        'dp_use_current' => false
                    ),
                    'callback' => array($this, 'filterByDateEnd')
                ))
                ->add('blame', 'doctrine_orm_callback', array(
                    'label' => 'User',
                    'field_type' => 'entity',
                    'field_options' => array(
                        'class' => 'Application\Sonata\UserBundle\Entity\User\User'),
                    'callback' => array($this, 'filterByUser')
                ))
        /*
          ->add('ip', 'doctrine_orm_callback', array(
          'label' => 'IP',
          'field_type' => 'choice',
          'field_options' => array(
          'choices' => $ips
          ),
          'callback' => array($this, 'filterByIp')
          ))
         */

        ;
    }

    public function filterByUser($queryBuilder, $alias, $field, $value) {
        if (!$value['value']) {
            return;
        }
        $user = $value['value'];
        $queryBuilder->innerJoin($alias . '.blame', 'p')
                ->andWhere('p.fk =' . $user->getId());
    }

    /*
      public function filterByIp($queryBuilder, $alias, $field, $value) {
      if (!$value['value']) {
      return;
      }
      //dump($value);
      //exit;
      $queryBuilder->andWhere($alias . '.ip = \'' . $value['value'] . '\'');
      }
     */

    public function filterByDateStart($queryBuilder, $alias, $field, $value) {
        /* @var $queryBuilder \Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery */
        if (!$value['value']) {
            return;
        }

        $queryBuilder->andWhere($alias . '.loggedAt >= \'' . $value['value']->format('Y-m-d 00:00:00') . '\'');
    }

    public function filterByDateEnd($queryBuilder, $alias, $field, $value) {
        /* @var $queryBuilder \Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery */
        if (!$value['value']) {
            return;
        }

        $queryBuilder->andWhere($alias . '.loggedAt <= \'' . $value['value']->format('Y-m-d 23:59:59') . '\'');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper) {

        unset($this->listModes['mosaic']);

        $listMapper
                ->remove('batch')
                ->add('action', null, array(
                    'template' => 'ApplicationDataDogAuditBundle:Admin:list__action_row.html.twig',
                    'label' => ' ',
                    'sortable' => false,
                    'attr' => array(
                        'width' => '20px'
                    )
                        )
                )
                ->add('source.TypLabel', null, array(
                    'template' => 'ApplicationDataDogAuditBundle:Admin:list__logs_row.html.twig'
                ))
                //->add('diff')
                ->add('blame.label', null, array(
                    'attr' => array(
                        'width' => '120px'
                    )
                ))
                ->add('loggedAt', null, array(
                    'pattern' => 'Y-MM-dd H:mm:ss',
                    'attr' => array(
                        'width' => '120px'
                    )
                ))
        //->add('ip')
        //->add('id')
        /* ->add('_action', 'actions', array(
          'actions' => array(
          'show' => array(),
          'edit' => array(),
          'delete' => array(),
          )
          )) */
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
        //     ->add('action')
        //     ->add('tbl')
        //     ->add('diff')
        //     ->add('loggedAt')
        //     ->add('id')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('action')
                ->add('tbl')
                ->add('diff')
                ->add('loggedAt')
                ->add('id')
        ;
    }

}
