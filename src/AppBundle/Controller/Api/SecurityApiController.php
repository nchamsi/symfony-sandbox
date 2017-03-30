<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\CollectionRepresentation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class SecurityApiController extends FOSRestController {

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Login to System",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     401 = "Returned when user is Unauthorized"
     *   }
     * )
     * 
     * @FOSRest\Post("/_login_check",options={"expose"=true})
     * @FOSRest\QueryParam(name="username", nullable=false, description="Username or Email.")
     * @FOSRest\QueryParam(name="password", nullable=false, description="Password.")
     * 
     */
    public function loginCheckAction(Request $request) {
        return null;
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Refresh Login Token",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     401 = "Returned when user is Unauthorized"
     *   }
     * )
     * 
     * @FOSRest\Post("/_token/refresh",options={"expose"=true})
     * @FOSRest\QueryParam(name="refresh_token", nullable=false, description="Refresh Token.")
     * 
     */
    public function tokenRefreshAction(Request $request) {
        return null;
    }

}
