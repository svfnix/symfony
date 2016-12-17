<?php

namespace AppBundle\Repository;

use AppBundle\Entity\UserGroup;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Tools\Pagination\Paginator;


/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserGroupRepository extends EntityRepository
{
    /**
     * @param $id
     * @return UserGroup|null
     */
    public function findOneById($id)
    {
        return $this
            ->createQueryBuilder('g')
            ->where('g.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function filter($search, $page, $count, $order_by, $sort)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->select('ug')
            ->from('AppBundle:UserGroup', 'ug')
        ;

        if(!empty($search)) {

            $search = explode(' ', $search);

            $q = array_shift($search);
            $qb->where($qb->expr()->like("CONCAT(ug.title, ' ', ug.name)", $qb->expr()->literal('%' . $q . '%')));

            foreach ($search as $q) {
                $qb->andWhere($qb->expr()->like("CONCAT(ug.title, ' ', ug.name)", $qb->expr()->literal('%' . $q . '%')));
            }
        }

        if(!empty($order_by)) {
            $qb->orderBy("ug.{$order_by}", $sort);
        }

        $qb
            ->setFirstResult($page * $count)
            ->setMaxResults($count)
        ;

        return new Paginator($qb->getQuery());
    }

    public function bulkDelete($ids)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb
            ->delete('AppBundle:UserGroup', 'ug')
            ->where($qb->expr()->in('ug.id', $ids))
            ->getQuery()
            ->execute()
        ;
    }
}
