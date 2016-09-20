<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel {

    public function registerBundles() {
        $bundles = array(
            /*
              new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
              new Symfony\Bundle\SecurityBundle\SecurityBundle(),
              new Symfony\Bundle\TwigBundle\TwigBundle(),
              new Symfony\Bundle\MonologBundle\MonologBundle(),
              new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
              new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
              new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
              new AppBundle\AppBundle(),
             */

            //-------------------------------------------------------------------
            // SYMFONY STANDARD EDITION
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            // DOCTRINE
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            // KNP HELPER BUNDLES
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            // SONATA FEATURE
            new FOS\UserBundle\FOSUserBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),
            //new Sonata\PageBundle\SonataPageBundle(),
            //new Sonata\NewsBundle\SonataNewsBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            // Disable this if you don't want the audit on entities
            // new SimpleThings\EntityAudit\SimpleThingsEntityAuditBundle(),
            // API
            new FOS\RestBundle\FOSRestBundle(),
            new Bazinga\Bundle\HateoasBundle\BazingaHateoasBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            // SONATA E-COMMERCE
            //new Sonata\BasketBundle\SonataBasketBundle(),
            //new Sonata\CustomerBundle\SonataCustomerBundle(),
            //new Sonata\DeliveryBundle\SonataDeliveryBundle(),
            //new Sonata\InvoiceBundle\SonataInvoiceBundle(),
            //new Sonata\OrderBundle\SonataOrderBundle(),
            //new Sonata\PaymentBundle\SonataPaymentBundle(),
            //new Sonata\ProductBundle\SonataProductBundle(),
            //new Sonata\PriceBundle\SonataPriceBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            //new FOS\CommentBundle\FOSCommentBundle(),
            //new Sonata\CommentBundle\SonataCommentBundle(),
            // SONATA FOUNDATION
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Sonata\CacheBundle\SonataCacheBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\SeoBundle\SonataSeoBundle(),
            new Sonata\ClassificationBundle\SonataClassificationBundle(),
            new Sonata\NotificationBundle\SonataNotificationBundle(),
            new Sonata\DatagridBundle\SonataDatagridBundle(),
            // Search Integration
            //new FOS\ElasticaBundle\FOSElasticaBundle(),
            // CMF Integration
            new Symfony\Cmf\Bundle\RoutingBundle\CmfRoutingBundle(),
            // DEMO and QA - Can be deleted
            //new Sonata\Bundle\DemoBundle\SonataDemoBundle(),
            //new Sonata\Bundle\QABundle\SonataQABundle(),
            // Disable this if you don't want the timeline in the admin
            //new Spy\TimelineBundle\SpyTimelineBundle(),
            //new Sonata\TimelineBundle\SonataTimelineBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            // another bundles
            // FOS Js Routing Bundle
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            // Ideup Paginator Bundle
            new Ideup\SimplePaginatorBundle\IdeupSimplePaginatorBundle(),
            //  Lexik Form Filter Bundle 
            new Lexik\Bundle\FormFilterBundle\LexikFormFilterBundle(),
            // Liip Image Bundle
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Liip\DoctrineCacheBundle\LiipDoctrineCacheBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            // Anothers util bundles
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Shtumi\UsefulBundle\ShtumiUsefulBundle(),
            new DataDog\AuditBundle\DataDogAuditBundle(),
            //new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            // Captcha bundles
            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            # JWT Authorization
            new Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle(),
            new Gesdinet\JWTRefreshTokenBundle\GesdinetJWTRefreshTokenBundle(),
            /*
             * application sonata bundles
             */
            new Application\Sonata\AdminBundle\ApplicationSonataAdminBundle('SonataAdminBundle'),
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle('SonataUserBundle'),
            new Application\Sonata\ClassificationBundle\ApplicationSonataClassificationBundle('SonataClassificationBundle'),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle('SonataMediaBundle'),
            new Application\Sonata\NotificationBundle\ApplicationSonataNotificationBundle('SonataNotificationBundle'),
            //new Application\Sonata\PageBundle\ApplicationSonataPageBundle('SonataPageBundle'),
            new Application\DataDog\AuditBundle\ApplicationDataDogAuditBundle('DataDogAuditBundle'),
            //-------------------------------------------------------------------
            // AppBundle
            new AppBundle\AppBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader) {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

}
