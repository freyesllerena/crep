<?php

namespace AppBundle\Repository\Statistiques;

use AppBundle\Entity\CampagnePnc;

/**
 * StatCampagnePncRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StatCampagnePncRepository extends \Doctrine\ORM\EntityRepository
{
    public function getHistoriqueIndicateurs(CampagnePnc $campagnePnc)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->where('s.campagnePnc = :CAMPAGNE_PNC')
        ->setParameter('CAMPAGNE_PNC', $campagnePnc)
        ->orderBy('s.dateStat');

        return $qb->getQuery()->getResult();
    }
}
