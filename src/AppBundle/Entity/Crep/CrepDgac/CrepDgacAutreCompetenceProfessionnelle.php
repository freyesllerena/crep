<?php

namespace AppBundle\Entity\Crep\CrepDgac;

use AppBundle\Entity\Competence;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Entity\Crep;

/**
 * CrepDgacAutreCompetenceProfessionnelle.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CrepRepository\CrepDgacRepository\CrepDgacAutreCompetenceProfessionnelleRepository")
 */
class CrepDgacAutreCompetenceProfessionnelle extends Competence
{
    /**
     * @ORM\ManyToOne(targetEntity="CrepDgac", inversedBy="autresCompetencesProfessionnelles")
     */
    protected $crep;
	
    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $niveauRequis;
    
    
   	/**
	 * Set crep.
	 *
	 * @param \AppBundle\Entity\Crep\CrepDgac\CrepDgac $crep
	 *
	 * @return AutreCompetenceProfessionnelle
	 */
	public function setCrep(\AppBundle\Entity\Crep\CrepDgac\CrepDgac $crep = null)
	{
		$this->crep = $crep;
	
		return $this;
	}
	
	public function getCrep()
	{
		return $this->crep;
	}
    
    /**
     * Set niveauRequis.
     *
     * @param int $niveauRequis
     *
     * @return Competence
     */
    public function setNiveauRequis($niveauRequis)
    {
    	$this->niveauRequis = $niveauRequis;
    
    	return $this;
    }
    
    /**
     * Get niveauRequis.
     *
     * @return int
     */
    public function getNiveauRequis()
    {
    	return $this->niveauRequis;
    }
    
}
