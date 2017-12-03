<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Users controller.
 *
 * @Route("api/users")
 */
class UsersController extends Controller
{
    /**
     * Get users.
     *
     * @param Request $request
     *
     * @Route("/", name="get_users")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getUsersAction(Request $request)
    {
        /**
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * @var User[]
         */
        $users = $em->getRepository(User::class)->getUsers(array(
            'name' => $request->get('name')
        ));

        return new JsonResponse(
            $this->container->get('adcash.util.serializer')->serialize($users)
        );
    }
}
