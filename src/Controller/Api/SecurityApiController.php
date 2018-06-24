<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Request;

use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SecurityApiController
 * @package App\Controller\Api
 *
 * * @Route("/api")
 */
class SecurityApiController
{

    /**
     *  Login into system.
     *
     * @Route("/_login_check", methods={"POST"})
     *
     * @SWG\Response(response=200, description="Login into system.")
     *
     * @SWG\Parameter(name="username", in="body", schema={"default"})
     * @SWG\Parameter(name="password", in="body", schema={"default"})
     *
     * @SWG\Tag(name="Security")
     *
     */
    public function loginCheckAction(Request $request)
    {
        return null;
    }

    /**
     *  Refresh Security Token.
     *
     * @Route("/_token/refresh", methods={"POST"})
     *
     * @SWG\Response(response=200, description="Returned when successful")
     *
     * @SWG\Parameter(name="refresh_token", in="body", schema={"default"})
     *
     * @SWG\Tag(name="Security")
     *
     * @Security(name="Bearer")
     */
    public function tokenRefreshAction(Request $request)
    {
        return null;
    }

}
