<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CampagneBrhp;

/**
 * FormationSuivieRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FormationSuivieRepository extends \Doctrine\ORM\EntityRepository
{
    public function exportFormations(CampagneBrhp $campagneBrhp, $modeleCrep)
    {
        $qb = $this->createQueryBuilder('formation');
        $qb
        ->select('agent.matricule as a_matricule, agent.email as a_email, agent.civilite as a_civilite, agent.nom as a_nom,  agent.prenom as a_prenom')
        ->addSelect('agent.categorieAgent as a_categorieAgent, agent.corps as a_corps, agent.grade as a_grade, agent.affectation as a_affectation')
        ->addSelect('crep.dateNotification as c_dateNotification, crep.dateRefusNotification as c_dateRefusNotification')

        ->addSelect('formation.libelle as f_libelle')
        ->addSelect('formation.annee as f_annee, formation.commentaires as f_commentaires') // Pour le CrepMcc
        ->innerJoin('formation.crep', 'crep')
        ->innerJoin('crep.agent', 'agent')
        ->where('agent.campagneBrhp = :CAMPAGNE_BRHP')
        ->andWhere('crep.crepPapier IS NULL')
        ->andWhere('crep INSTANCE OF '.$modeleCrep)
        ->orderBy('agent.nom')
        ->addOrderBy('agent.prenom')
        ->setParameter('CAMPAGNE_BRHP', $campagneBrhp);

        $reslut = $qb->getQuery()->getScalarResult();

        return $reslut;
    }
}
