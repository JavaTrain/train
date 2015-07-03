<?php
namespace Home\TestBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Test\UserBundle\Entity\User;

class UserRepository extends EntityRepository
{
    public function findByCourseRoleGroupId($course = null, $role = null, $group = null, $id = null)
    {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb   ->select('u', 'c', 'g')
                    ->from('HomeTestBundle:User', 'u')
                    ->leftJoin('u.courses', 'c')
                    ->leftJoin('u.clusters', 'g')
                    ->orderBy('u.status', 'DESC');
            if(!empty($course)) {
                $qb->andWhere('c.name = :name')
                ->setParameter('name', $course);
            }

            if(!empty($role)) {
                $qb->andWhere('u.role = :role')
                ->setParameter('role', $role);
            }

            if(!empty($group)) {
                $qb->andWhere('g.id = :cluster')
                    ->setParameter('group', $group);
            }
            if(!empty($id)) {
                $qb->andWhere('u.id = :id')
                    ->setParameter('id', $id);
            }


        return $qb->getQuery()->getResult();
//        exit(\Doctrine\Common\Util\Debug::dump($qb->getQuery()->getResult()));

    }


    public function findPayments($id)
    {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb ->select('p', 'u', 'g', 'c')
            ->from('HomeTestBundle:Payment', 'p')
            ->leftJoin('p.user', 'u')
            ->leftJoin('p.cluster', 'g')
            ->leftJoin('g.course', 'c')
            ->andWhere('u.id = :uid')
            ->setParameter('uid', $id)

        ;
        $res = $qb->getQuery()->getResult();

        if(!$res){
            return false;
        }

        return $res;

    }



}