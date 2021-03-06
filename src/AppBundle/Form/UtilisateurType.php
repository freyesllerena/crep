<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\EnumTypes\EnumCivilite;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UtilisateurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('civilite', ChoiceType::class, array(
                    'choices' => array(
                        'M.' => EnumCivilite::MONSIEUR,
                        'Mme' => EnumCivilite::MADAME,
                    ),
                    'expanded' => false,
                    'multiple' => false,
                    'placeholder' => '',
            ))
            ->add('email')

            ->add('ministere', null)
            ->add('roles', ChoiceType::class, array(
                            'choices' => array(
                                'Administrateur'                => 'ROLE_ADMIN',
                                'Administrateur ministériel'    => 'ROLE_ADMIN_MIN',
                                'Pilote national de campagne'   => 'ROLE_PNC',
                                'Responsable local de campagne' => 'ROLE_RLC',
                                'Acteur RH de proximité'        => 'ROLE_BRHP',
                                'Acteur RH de proximité consultation' => 'ROLE_BRHP_CONSULT',
                                'N+2'                           => 'ROLE_AH',
                                'N+1'                           => 'ROLE_SHD',
                                'Agent'                         => 'ROLE_AGENT'
                            ),
                            'expanded' => true,
                            'multiple' => true,
                            'mapped' => true,
                ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Utilisateur',
        ));
    }
}
