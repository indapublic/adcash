<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Entity\UserOrder;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * User orders controller.
 *
 * @Route("api/orders")
 */
class UsersOrderController extends Controller
{
    /**
     * Get orders.
     *
     * @param Request $request
     *
     * @Route("/", name="get_orders")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getOrdersAction(Request $request)
    {
        /**
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * @var UserOrder[]
         */
        $orders = $em->getRepository(UserOrder::class)->getOrders(array(
            'period-value' => $request->get('period-value'),
            'search-text' => $request->get('search-text')
        ));

        return new JsonResponse(
            $this->container->get('adcash.util.serializer')->serialize($orders)
        );
    }

    /**
     * Get order.
     *
     * @param string $orderId
     *
     * @Route("/{orderId}", name="get_order")
     * @Method("GET")
     *
     * @return JsonResponse
     */
    public function getOrderAction(string $orderId)
    {
        /**
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * @var UserOrder
         */
        $order = $em->getRepository(UserOrder::class)->find($orderId);
        if (!$order instanceof UserOrder) {
            throw new NotFoundHttpException(sprintf('Order %s not found', $orderId));
        }

        return new JsonResponse(
            $this->container->get('adcash.util.serializer')->serialize($order)
        );
    }

    /**
     * Add new order.
     *
     * @param Request $request
     *
     * @Route("/", name="add_order")
     * @Method("POST")
     *
     * @return JsonResponse
     */
    public function addOrderAction(Request $request)
    {
        /**
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        $userId = $request->get('user-id');
        $productId = $request->get('product-id');
        $quantity = $request->get('quantity');

        if (!$userId) {
            throw new BadRequestHttpException(sprintf('User should be defined'));
        }
        if (!$productId) {
            throw new BadRequestHttpException(sprintf('Product should be defined'));
        }
        if (!$quantity) {
            throw new BadRequestHttpException(sprintf('Quantity should be defined'));
        }
        if ($quantity <= 0) {
            throw new BadRequestHttpException(sprintf('Quantity should be positive'));
        }

        /**
         * @var Product
         */
        $product = $em->getRepository(Product::class)->find($productId);
        if (!$product instanceof Product) {
            throw new NotFoundHttpException(sprintf('Product %s not found', $productId));
        }

        /**
         * @var User
         */
        $user = $em->getRepository(User::class)->find($userId);
        if (!$user instanceof User) {
            throw new NotFoundHttpException(sprintf('User %s not found', $userId));
        }

        /**
         * @var UserOrder
         */
        $order = new UserOrder();
        $order
            ->setUser($user)
            ->setProduct($product)
            ->setQuantity($quantity)
        ;

        $em->persist($order);
        $em->flush();

        return new JsonResponse(
            $this->container->get('adcash.util.serializer')->serialize($order),
            Response::HTTP_CREATED
        );
    }

    /**
     * Update order.
     *
     * @param string $orderId
     * @param Request $request
     *
     * @Route("/{orderId}", name="update_order")
     * @Method("PUT")
     *
     * @return JsonResponse
     */
    public function updateOrderAction(string $orderId, Request $request)
    {
        /**
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * @var UserOrder
         */
        $order = $em->getRepository(UserOrder::class)->find($orderId);
        if (!$order instanceof UserOrder) {
            throw new NotFoundHttpException(sprintf('Order %s not found', $orderId));
        }

        $userId = $request->get('user-id');
        $productId = $request->get('product-id');
        $quantity = $request->get('quantity');

        if (!$userId) {
            throw new BadRequestHttpException(sprintf('User should be defined'));
        }
        if (!$productId) {
            throw new BadRequestHttpException(sprintf('Product should be defined'));
        }
        if (!$quantity) {
            throw new BadRequestHttpException(sprintf('Quantity should be defined'));
        }
        if ($quantity <= 0) {
            throw new BadRequestHttpException(sprintf('Quantity should be positive'));
        }

        /**
         * @var Product
         */
        $product = $em->getRepository(Product::class)->find($productId);
        if (!$product instanceof Product) {
            throw new NotFoundHttpException(sprintf('Product %s not found', $productId));
        }

        /**
         * @var User
         */
        $user = $em->getRepository(User::class)->find($userId);
        if (!$user instanceof User) {
            throw new NotFoundHttpException(sprintf('User %s not found', $userId));
        }

        $order
            ->setUser($user)
            ->setProduct($product)
            ->setQuantity($quantity)
        ;

        $em->persist($order);
        $em->flush();

        return new JsonResponse(
            $this->container->get('adcash.util.serializer')->serialize($order),
            Response::HTTP_OK
        );
    }

    /**
     * Delete order.
     *
     * @param string $orderId
     *
     * @Route("/{orderId}", name="delete_order")
     * @Method("DELETE")
     *
     * @return JsonResponse
     */
    public function deleteOrderAction(string $orderId)
    {
        /**
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * @var UserOrder
         */
        $order = $em->getRepository(UserOrder::class)->find($orderId);
        if (!$order instanceof UserOrder) {
            throw new NotFoundHttpException(sprintf('Order %s not found', $orderId));
        }

        $em->remove($order);
        $em->flush();

        return new JsonResponse(array(), Response::HTTP_NO_CONTENT);
    }
}
