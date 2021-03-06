<?php

namespace AppBundle\Security;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use AppBundle\Entity\ModeleCrep;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Repository\AgentRepository;

class ModeleCrepVoter extends Voter
{
    /* @var $decisionManager AccessDecisionManager */
    protected $decisionManager;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    // Liste des actions supportées
    const EXPORTER_MODELE_VIERGE = 'exporter_modele_vierge';

    public function __construct(AccessDecisionManagerInterface $decisionManager, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // Si l'attribut n'est pas supporté, return false
        if (!in_array($attribute, array(self::EXPORTER_MODELE_VIERGE))) {
            return false;
        }

        // Si l'objet n'est pas de type ModeleCrep, il n'est pas supporté
        if ($subject && !$subject instanceof ModeleCrep) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $utilisateur = $token->getUser();

        if (!$utilisateur instanceof Utilisateur) {
            // Si l'utilisateur n'est pas connecté, l'accès est refusé
            return false;
        }

        // Si l'utilisateur est ADMIN, l'accès est accordé
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }

        /* @var $modeleCrep ModeleCrep  */
        $modeleCrep = $subject;

        switch ($attribute) {
            case self::EXPORTER_MODELE_VIERGE:
                return $this->peutExporterModeleVierge($modeleCrep, $utilisateur);
        }

        throw new \LogicException("Erreur de logique dans BrhpVoter : type d'accès ".$attribute.' non géré !');
    }

    private function peutExporterModeleVierge(ModeleCrep $modeleCrep, Utilisateur $utilisateur)
    {
        // Un utilisateur peut exporter les modèles vierges de son ministère
        if ($modeleCrep->getMinistere() === $utilisateur->getMinistere()) {
            return true;
        }
        
        /* @var $agentRepository AgentRepository */
        $agentRepository = $this->em->getRepository('AppBundle:Agent');
        
        if ($agentRepository->isShdByMinistere($utilisateur, $modeleCrep->getMinistere())) {
            return true;
        }
        
        if ($agentRepository->isAhByMinistere($utilisateur, $modeleCrep->getMinistere())) {
            return true;
        }
        

        
        // Dans tous les autres cas, on refuse l'accès
        return false;
    }
}
