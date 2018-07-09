<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
class SecurityApiController extends Controller
{
    /**
     *  Login into system.
     *
     * @Route("/_login_check", methods={"POST"})
     *
     * @SWG\Post(
     *         schemes={"http"},
     *         produces={"application/json"},
     *         consumes={"text/html","application/json"},
     *         @SWG\Parameter(
     *              name="body",
     *              type="json",
     *              in="body",
     *              description="Login parameters",
     *              default="{""username"":""user"",""password"":""pass""}",
     *              @SWG\Schema(
     *                 type="object",
     *                 items={
     *                     @SWG\Property(property="username", type="string"),
     *                     @SWG\Property(property="password", type="string"),
     *                 }
     *              )
     *          ),
     *
     *          @SWG\Response(response=200, description="when login is successfully."),
     *
     *          @SWG\Response(response=400, description="when username or password are wrong."),
     *
     *          @SWG\Tag(name="Security"),
     *    )
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
     * @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         description="Refresh Login token",
     *         type="json",
     *         default="{""refresh_token"":""refresh_token""}",
     *         @SWG\Schema(
     *             type="object",
     *             items={
     *                 @SWG\Property(property="refresh_token", type="string")
     *             }
     *         )
     *     )
     *
     * @SWG\Response(response=200, description="Returned when successful")
     *
     * @SWG\Response(response=400, description="Bad Request")
     *
     * @SWG\Tag(name="Security")
     *
     * @Security(name="Bearer")
     */
    public function tokenRefreshAction(Request $request)
    {
        return $this->get('gesdinet.jwtrefreshtoken')->refresh($request);
    }

}
