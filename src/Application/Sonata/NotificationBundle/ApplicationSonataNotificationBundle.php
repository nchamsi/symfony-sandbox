<?php

namespace Application\Sonata\NotificationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationSonataNotificationBundle extends Bundle {

    public function getParent() {
        return 'SonataNotificationBundle';
    }

}
