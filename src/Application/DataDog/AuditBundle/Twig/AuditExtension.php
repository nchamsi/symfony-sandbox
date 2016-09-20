<?php

namespace Application\DataDog\AuditBundle\Twig;

use DataDog\AuditBundle\Entity\AuditLog;

class AuditExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $defaults = [
            'is_safe' => ['html'],
            'needs_environment' => true,
        ];

        return [
            new \Twig_SimpleFunction('audit', [$this, 'audit'], $defaults),
            new \Twig_SimpleFunction('audit_icon', [$this, 'icon'], $defaults),
            new \Twig_SimpleFunction('decamelize', [$this, 'decamelize'], $defaults),
            new \Twig_SimpleFunction('audit_value', [$this, 'value'], $defaults),
            new \Twig_SimpleFunction('audit_assoc', [$this, 'assoc'], $defaults),
            new \Twig_SimpleFunction('audit_blame', [$this, 'blame'], $defaults),
            new \Twig_SimpleFunction('audit_diff', [$this, 'diff'], $defaults),
        ];
    }

    public function audit(\Twig_Environment $twig, AuditLog $log, $admin)
    {
        return $twig->render("ApplicationDataDogAuditBundle:Audit:{$log->getAction()}.html.twig", compact('log', 'admin'));
    }
    
    public function icon(\Twig_Environment $twig, AuditLog $log)
    {
        $action = $log->getAction();
        switch($action){
            case 'insert':
                $icon = 'fa-plus';
                $icon_color = 'text-success';
                break;
            case 'update':
                $icon = 'fa-pencil';
                $icon_color = 'text-info';
                break;
            case 'remove':
                $icon = 'fa-remove';
                $icon_color = 'text-danger';
                break;
            case 'dissociate':
                $icon = 'fa-random';
                $icon_color = 'text-warning';
                break;
            case 'associate':
                $icon = 'fa-random';
                $icon_color = 'text-success';
                break;
            case 'login':
                $icon = 'fa-user';
                $icon_color = 'text-default';
                break;
            case 'logout':
                $icon = 'fa-user';
                $icon_color = 'text-danger';
                break;
            default:
                $icon = '';
                $icon_color = '';
                break;
                
        }
        return $twig->render("ApplicationDataDogAuditBundle:Audit:icon.html.twig", compact('log', 'icon', 'icon_color'));
    }

    public function assoc(\Twig_Environment $twig, $assoc)
    {
        return $twig->render("ApplicationDataDogAuditBundle:Audit:assoc.html.twig", compact('assoc'));
    }
    
    public function diff(\Twig_Environment $twig, AuditLog $log, $admin)
    {
        return $twig->render("ApplicationDataDogAuditBundle:Audit:diff.html.twig", compact('log', 'admin'));
    }

    public function blame(\Twig_Environment $twig, $blame)
    {
        return $twig->render("ApplicationDataDogAuditBundle:Audit:blame.html.twig", compact('blame'));
    }

    public function value(\Twig_Environment $twig, $val)
    {
        switch (true) {
        case is_bool($val):
            return $val ? 'true' : 'false';
        case is_array($val) && isset($val['fk']):
            return $this->assoc($twig, $val);
        case is_array($val):
            return json_encode($val);
        case is_string($val):
            return strlen($val) > 60 ? substr($val, 0, 60) . '...' : $val;
        case is_null($val):
            return ' ';
        default:
            return $val;
        }
    }
    
    public function decamelize(\Twig_Environment $twig, $string) 
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }

    public function getName()
    {
        return 'app_audit_extension';
    }
}
