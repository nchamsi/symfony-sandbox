<?php

namespace Application\Sonata\PageBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationSonataPageBundle extends Bundle {

    public function getParent() {
        return 'SonataPageBundle';
    }

}
