<?php

namespace AppBundle\Entity\Crep\CrepMso3;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompetenceAgent.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepMso3QualiteRelationnelleAgentAutreRepository")
 */
class CrepMso3QualiteRelationnelleAgentAutre extends CrepMso3Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepMso3", inversedBy="qualitesRelationnellesAgentAutres")
     */
    protected $crep;

    public function __construct($libelle = null)
    {
        parent::__construct($libelle);
    }

    /**
     * Set crep.
     *
     * @param \AppBundle\Entity\Crep\CrepMso3\CrepMso3 $crep
     *
     * @return CrepMso3Competence
     */
    public function setCrep(\AppBundle\Entity\Crep\CrepMso3\CrepMso3 $crep = null)
    {
        $this->crep = $crep;

        return $this;
    }

    /**
     * Get crep.
     *
     * @return \AppBundle\Entity\Crep\CrepMso3\CrepMso3
     */
    public function getCrep()
    {
        return $this->crep;
    }
}
