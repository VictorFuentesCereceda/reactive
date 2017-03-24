<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * FormRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FormRepository extends EntityRepository
{
    public function findWithAnswers(){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $forms = $qb->select('f')
            ->from('AppBundle:Form', 'f')
            ->innerJoin("f.answers","ans")
            ->getQuery()
            ->getResult();

        return $forms;
    }
}
