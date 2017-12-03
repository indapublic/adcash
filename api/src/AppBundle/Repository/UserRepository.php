<?php

namespace AppBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    public function getUsers($criteria = array())
    {
        $name = $criteria['name'];

        /**
         * @var QueryBuilder
         */
        $qb = $this
            ->createQueryBuilder('u')
        ;

        if (!!$name && strlen($name) > 0) {
            $qb
                ->andWhere('u.username like :search')
                ->setParameter('search', '%' . mb_strtolower($name) . '%')
            ;
        }

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
}
