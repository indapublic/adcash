<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Products controller.
 *
 * @Route("api/products")
 */
class ProductsController extends Controller
{
    /**
     * Get products.
     *
     * @Route("/", name="get_products")
     * @Method("GET")
     */
    public function getProductsAction()
    {
        /**
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * @var Product[]
         */
        $products = $em->getRepository(Product::class)->findAll();

        return new JsonResponse(
            $this->container->get('adcash.util.serializer')->serialize($products)
        );
    }
}
