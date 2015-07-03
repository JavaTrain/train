<?php
namespace Home\TestBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Home\TestBundle\Entity\User;

class PaymentRepository extends EntityRepository
{
    public function findByCourseGroupId($course = null, $role = null, $group = null, $id = null)
    {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('u', 'c', 'g', 'p')
            ->from('HomeTestBundle:Payment', 'p')
            ->leftJoin('p.cluster', 'g')
            ->leftJoin('g.course', 'c')
            ->leftJoin('p.user', 'u');
        if (!empty($course)) {
            $qb->andWhere('c.name = :name')
                ->setParameter('name', $course);
        }

        if (!empty($role)) {
            $qb->andWhere('u.role = :role')
                ->setParameter('role', $role);
        }

        if (!empty($group)) {
            $qb->andWhere('g.id = :group')
                ->setParameter('group', $group);
        }
        if (!empty($id)) {
            $qb->andWhere('u.id = :id')
                ->setParameter('id', $id);
        }

        //        exit(\Doctrine\Common\Util\Debug::dump($qb->getQuery()->getResult()));
        return $qb->getQuery()->getResult();
    }

}

