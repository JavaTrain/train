<?php
namespace Home\TestBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClusterRepository extends EntityRepository
{
    public function findByCourseRoleId($course = null, $role = null, $id = null, $gid = null)
    {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb ->select('g', 'u', 'c')
            ->from('HomeTestBundle:Cluster', 'g')
            ->leftJoin('g.course', 'c')
            ->leftJoin('g.users', 'u');
        if(!empty($course)) {
            $qb ->andWhere('c.name = :name')
                ->setParameter('name', $course);
        }

        if(!empty($role)) {
            $qb->andWhere('u.role = :role')
                ->setParameter('role', $role);
        }

        if(!empty($id)) {
            $qb->andWhere('u.id = :id')
                ->setParameter('id', $id);
        }

        if(!empty($gid)) {
            $qb->andWhere('g.id = :id')
                ->setParameter('id', $gid);
        }


//        exit(\Doctrine\Common\Util\Debug::dump($qb->getQuery()->getResult()));

        if(!empty($gid))
            return $qb->getQuery()->getResult()[0];

        return $qb->getQuery()->getResult();

    }

    public function findPayments($uid, $gid)
    {

        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb ->select('p', 'u', 'g', 'c')
            ->from('HomeTestBundle:Payment', 'p')
            ->leftJoin('p.user', 'u')
            ->leftJoin('p.cluster', 'g')
            ->leftJoin('g.course', 'c')
            ->andWhere('u.id = :uid')
            ->setParameter('uid', $uid)
            ->andWhere('g.id = :gid')
            ->setParameter('gid', $gid)
        ;
        $res = $qb->getQuery()->getResult();

        if(!$res){
            return false;
        }

        $sum = 0;

        foreach($res as $item)
            $sum += $item->getAmount();

        $loan = ($res[0]->getCluster()->getCourse()->getPrice()) - $sum;

//        exit(\Doctrine\Common\Util\Debug::dump($res));
//        exit(\Doctrine\Common\Util\Debug::dump($qb->getQuery()->getResult()));

//        return $qb->getQuery()->getResult();
        return [$res, $loan];

    }

}