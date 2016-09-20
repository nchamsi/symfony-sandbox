<?php

namespace Application\DataDog\AuditBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationDataDogAuditBundle extends Bundle
{
        public function getParent() {
        return 'DataDogAuditBundle';
    }
}
