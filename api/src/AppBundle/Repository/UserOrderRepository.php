<?php

namespace AppBundle\Repository;

use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * UserOrderRepository
 */
class UserOrderRepository extends EntityRepository
{
    public function getOrders($criteria = array()) {
        $periodValue = $criteria['period-value'];
        $searchText = $criteria['search-text'];

        /**
         * @var QueryBuilder
         */
        $qb = $this
            ->createQueryBuilder('uo')
        ;

        switch ($periodValue) {
            case 'all-time':
                break;
            case 'last-7-days':
                $last7days = new \DateTime();
                $last7days->modify('-7 days');
                $qb
                    ->andWhere('uo.dateCreated >= :date')
                    ->setParameter('date', $last7days)
                ;
                break;
            case 'today':
                $today = new \DateTime();
                $today->modify('today');
                $qb
                    ->andWhere('uo.dateCreated >= :date')
                    ->setParameter('date', $today)
                ;
                break;
        }

        if (!!$searchText && strlen($searchText) > 0) {
            $qb
                ->innerJoin('uo.product', 'p', Join::WITH)
                ->innerJoin('uo.user', 'u', Join::WITH)
                ->andWhere('p.name like :search or u.username like :search')
                ->setParameter('search', '%' . mb_strtolower($searchText) . '%')
            ;
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
