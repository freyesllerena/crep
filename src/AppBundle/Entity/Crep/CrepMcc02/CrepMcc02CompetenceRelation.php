<?php

namespace AppBundle\Entity\Crep\CrepMcc02;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\CompetenceTransverse;
use AppBundle\Entity\GenericEntity;

/**
 * CrepMcc02CompetenceRelation
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepMcc02Repository\CrepMcc02CompetenceRelationRepository")
 */
class CrepMcc02CompetenceRelation extends CrepMcc02Competence
{

    /**
     * @ORM\ManyToOne(targetEntity="CrepMcc02", inversedBy="competencesRelations")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $crep;


    /**
     * Get crep
     *
     * @return CrepMcc02
     */
    public function getCrep()
    {
        return $this->crep;
    }

    /**
     * Set crep
     *
     * @param CrepMcc02 $crep
     *
     * @return CrepMcc02CompetenceRelation
     */c
    public function setCrep(CrepMcc02 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }
}
