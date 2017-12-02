<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         * @var \AppBundle\Entity\Product
         */
        $product = new Product();
        $product
            ->setName('Coca-Cola')
            ->setPrice(1.8)
        ;

        $manager->persist($product);
        unset($product);

        $product = new Product();
        $product
            ->setName('Pepsi-Cola')
            ->setPrice(1.6)
            ->setDiscount(true)
        ;

        $manager->persist($product);
        unset($product);

        $manager->flush();
    }
}