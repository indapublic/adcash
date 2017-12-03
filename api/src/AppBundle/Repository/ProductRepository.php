<?php

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * ProductRepository
 */
class ProductRepository extends EntityRepository
{
    public function getProducts($criteria = array())
    {
        $name = $criteria['name'];

        /**
         * @var QueryBuilder
         */
        $qb = $this
            ->createQueryBuilder('p')
        ;

        if (!!$name && strlen($name) > 0) {
            $qb
                ->andWhere('p.name like :search')
                ->setParameter('search', '%' . mb_strtolower($name) . '%')
            ;
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
