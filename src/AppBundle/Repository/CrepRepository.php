<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Campagne;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\CampagneBrhp;
use AppBundle\Entity\CampagneRlc;
use AppBundle\Entity\CampagnePnc;
use AppBundle\Entity\Agent;
use AppBundle\Entity\Perimetre;
use AppBundle\EnumTypes\EnumStatutCrep;
use AppBundle\EnumTypes\EnumStatutCampagne;
use AppBundle\Entity\Ministere;
use AppBundle\Util\Util;
use AppBundle\Entity\Crep;
use AppBundle\Traits\ConditionsFiltre;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * CrepRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CrepRepository extends EntityRepository
{
    // Utilisation de trait
    use ConditionsFiltre;

    public function getNbCreps(Campagne $campagne, $perimetresRlc = [], $perimetresBrhp = [], $statuts = null, Agent $shd = null, Agent $ah = null, $categories = [], $affectations = [], $corps = [])
    {
        if ($shd && $ah) {
            throw new \Exception('Appel incorrect SHD ou AH');
        }

        $qb = $this->createQueryBuilder('crep');
        $qb->select('COUNT(crep)')
           ->leftjoin('crep.agent', 'agent')
           ->where('agent.evaluable = :EVALUABLE')
           ->setParameter('EVALUABLE', true);

        $this->addFiltreCategories($qb, $categories);
        $this->addFiltreAffectations($qb, $affectations);
        $this->addFiltreCorps($qb, $corps);

        /* @var $campagne CampagnePnc */
        if ($campagne instanceof CampagnePnc) {
            $qb->andWhere('agent.campagnePnc = :CAMPAGNE');
            $this->addFiltrePerimetresRlc($qb, $perimetresRlc);
            $this->addFiltrePerimetresBrhp($qb, $perimetresBrhp);
        }

        /* @var $campagne CampagneRlc */
        if ($campagne instanceof CampagneRlc) {
            $qb->andWhere('agent.campagneRlc = :CAMPAGNE');

            /* @var $perimetre PerimetreRlc */
//             if ($perimetre) {
//                 $qb->leftJoin('agent.campagneBrhp', 'campagneBrhp')
//                 ->andWhere('campagneBrhp.perimetreBrhp = :PERIMETRE_BRHP')
//                 ->setParameter('PERIMETRE_BRHP', $perimetre);
//             }
            $this->addFiltrePerimetresBrhp($qb, $perimetresBrhp);
        }

        if ($campagne instanceof CampagneBrhp) {
            $qb->andWhere('agent.campagneBrhp = :CAMPAGNE');
            if ($shd) {
                $qb->andWhere('agent.shd = :SHD')
                ->setParameter('SHD', $shd);
            } elseif ($ah) {
                $qb->andWhere('agent.ah = :AH')
                ->setParameter('AH', $ah);
            }
        }

        if ($statuts) {
            $qb->andWhere($qb->expr()->in('crep.statut', $statuts));
        }

        $qb->setParameter('CAMPAGNE', $campagne);
        
        // Mise en cache pendant 30 secondes
        $query = $qb->getQuery()->useResultCache(true, 30);
        $result = (int) $query->getSingleScalarResult();
        return $result;
    }

//     /**
//      * Renvoie le nombre de CREP par périmètre
//      */
//     public function getNbCreps(Campagne $campagne, Perimetre $perimetre, $statuts = null) {
//         $qb = $this->createQueryBuilder('c');
//         $qb->select('COUNT(c)');

//         /* @var $campagne CampagnePnc */
//         if($campagne instanceof CampagnePnc){
//             $qb->leftjoin('c.agent', 'a')
//             ->leftjoin('a.campagneBrhp', 'campagneBrhp')
//             ->leftjoin('campagneBrhp.campagneRlc', 'campagneRlc')
//             ->where('campagneRlc.campagnePnc = :CAMPAGNE_PNC')
//             ->setParameter('CAMPAGNE_PNC', $campagne);

//             /* @var $perimetre PerimetreRlc */
//             if ($perimetre != "Tous"){
//                 $qb->andWhere('campagneRlc.perimetreRlc = :PERIMETRE_PNC')
//                 ->setParameter('PERIMETRE_PNC', $perimetre);
//             }
//         }

//         /* @var $campagne CampagneRlc */
//         if($campagne instanceof CampagneRlc){
//             $qb->select('COUNT(c)')
//             ->leftjoin('c.agent', 'a')
//             ->leftjoin('a.campagneBrhp', 'campagneBrhp')
//             ->leftJoin('campagneBrhp.campagneRlc', 'campagneRlc')
//             ->where('campagneBrhp.campagneRlc = :CAMPAGNE_RLC')
//             ->setParameter('CAMPAGNE_RLC', $campagne);

//             /* @var $perimetre PerimetreRlc */
//             if ($perimetre == "Tous"){
//                 $qb->andWhere('campagneRlc.perimetreRlc = :PERIMETRE_RLC')
//                 ->setParameter('PERIMETRE_RLC', $campagne->getPerimetreRlc());
//             }else{
//                 $qb->andWhere('campagneRlc.perimetreRlc = :PERIMETRE_RLC')
//                 ->setParameter('PERIMETRE_RLC', $perimetre);
//             }
//         }

//     }

    /**
     * Renvoie le nombre de CREPs qu'un N+1 donné ($shd) gère lors d'une campagne donnée $campagneShd.
     */
    public function getNbCrepsByShd(CampagneBrhp $campagneShd, Agent $shd, $statuts = null)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)')
            ->leftjoin('c.agent', 'a')
            ->where('a.campagneBrhp = :CAMPAGNE_BRHP')
            ->andWhere('a.shd = :SHD')
            ->setParameter('CAMPAGNE_BRHP', $campagneShd)
            ->setParameter('SHD', $shd);

        if ($statuts) {
            $qb->andWhere($qb->expr()->in('c.statut', $statuts));
        }

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * Renvoie le nombre de CREPs qu'un N+2 donné ($ah) gère lors d'une campagne donnée $campagneAh.
     */
    public function getNbCrepsByAh(CampagneBrhp $campagneAh, Agent $ah, $statuts = null)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)')
        ->leftjoin('c.agent', 'a')
        ->where('a.campagneBrhp = :CAMPAGNE_BRHP')
        ->andWhere('a.ah = :AH')
        ->setParameter('CAMPAGNE_BRHP', $campagneAh)
        ->setParameter('AH', $ah);

        if ($statuts) {
            $qb->andWhere($qb->expr()->in('c.statut', $statuts));
        }

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getCreps(Utilisateur $utilisateur)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->leftjoin('c.agent', 'agent')
        ->leftJoin('agent.campagneBrhp', 'campagneBrhp')
        ->leftJoin('campagneBrhp.campagneRlc', 'campagneRlc')
        ->leftJoin('campagneRlc.campagnePnc', 'campagnePnc')
        ->where('agent.utilisateur = :UTILISATEUR')
        ->orderBy('campagnePnc.anneeEvaluee', 'DESC')
        ->setParameter('UTILISATEUR', $utilisateur);

        return $qb->getQuery()->getResult();
    }

    /**
     * Renvoie la liste des Campagnes BRHP d'un SHD.
     *
     * @param Utilisateur $shd
     */
    public function getCampagnesShd(Utilisateur $shd)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('(agent.campagneBrhp)')
        ->distinct('campagneBrhp.id')
        ->leftjoin('c.agent', 'agent')
        ->leftJoin('agent.campagneBrhp', 'campagneBrhp')
        ->leftJoin('campagneBrhp.campagneRlc', 'campagneRlc')
        ->leftJoin('campagneRlc.campagnePnc', 'campagnePnc')
        ->leftjoin('c.shd', 'shd')
        ->where('shd.utilisateur = :SHD')
        ->orderBy('campagnePnc.anneeEvaluee', 'DESC')
        ->setParameter('SHD', $shd);

        return $qb->getQuery()->getResult();
    }

    public function getCrep(Utilisateur $utilisateur, CampagneBrhp $campagneBrhp)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->leftjoin('c.agent', 'agent')
        ->where('agent.utilisateur = :UTILISATEUR')
        ->andWhere('agent.campagneBrhp = :CAMPAGNE_BRHP')
        ->setParameter('UTILISATEUR', $utilisateur)
        ->setParameter('CAMPAGNE_BRHP', $campagneBrhp);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Renvoie le nombre de creps d'un agent selon un statut donné.
     */
    public function getNbCrepsAgent(Utilisateur $utilisateur, $statut)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->select('COUNT(c)')
        ->leftjoin('c.agent', 'a')
        ->where('a.utilisateur = :UTILISATEUR')
        ->andWhere('c.statut = :STATUT')
        ->setParameter('UTILISATEUR', $utilisateur)
        ->setParameter('STATUT', $statut);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function getCrepsEnAbsenceVisaAgent()
    {
        $qb = $this->createQueryBuilder('crep')
        ->leftjoin('crep.agent', 'agent')
        ->leftjoin('agent.campagnePnc', 'campagnePnc')
        ->leftjoin('campagnePnc.ministere', 'ministere');

        $qb->where('campagnePnc.statut = :STATUT_CAMPAGNE_PNC')
        ->andWhere('crep.statut = :STATUT_CREP')
        ->andWhere('DATE_DIFF(CURRENT_TIMESTAMP(), crep.dateVisaShd) > ministere.delaiVisa')
        ->andWhere('crep.notificationAbsenceVisaAgent = 0')
        ->andWhere('crep.dateVisaShd IS NOT NULL')
        ->setParameter('STATUT_CREP', EnumStatutCrep::SIGNE_SHD)
        ->setParameter('STATUT_CAMPAGNE_PNC', EnumStatutCampagne::OUVERTE);

        // Le préresultat ne tient pas compte des week-ends est des jours fériés
        $preResultat = $qb->getQuery()->getResult();

        $resultat = array();
        $dateCourante = new \DateTime();

        /* @var $crep Crep */
        foreach ($preResultat as $crep) {
            $echeance = Util::calculeDate($crep->getDateVisaShd(), $crep->getAgent()->getCampagnePnc()->getMinistere()->getDelaiVisa());

            if ($dateCourante > $echeance) {
                $resultat[] = $crep;
            }
        }

        return $resultat;
    }
    
    public function getDernierCrep(Agent $agent){
    	
    	$qb1 = $this->createQueryBuilder('crep');
    	$qb1->select('MAX(crep.dateVisaShd)')
    	->leftjoin('crep.agent', 'agent')
    	->where('agent.email = :EMAIL_AGENT')
    	->andWhere('crep.dateVisaShd IS NOT NULL')
    	->setParameter('EMAIL_AGENT', $agent->getEmail());
    	
    	/* @var $query Query */
    	$query = $qb1->getQuery();
    	
    	$dateVisaShd = $query->getSingleScalarResult();
    	
    	if(!$dateVisaShd){
    		return null;
    	}
    	
    	/* @var $qb QueryBuilder */
    	$qb = $this->createQueryBuilder('crep');
    	
    	$qb->leftjoin('crep.agent', 'agent')
    	->where('agent.email = :EMAIL_AGENT')
    	->andWhere('crep.dateVisaShd IS NOT NULL')
    	->andWhere('crep.dateVisaShd = :DATE_VISA_SHD')
    	->setParameter('EMAIL_AGENT', $agent->getEmail())
    	->setParameter('DATE_VISA_SHD', $dateVisaShd);
    	
    	return $qb->getQuery()->getSingleResult();	
    }
}
