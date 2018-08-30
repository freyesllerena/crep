<?php
namespace AppBundle\Form\Crep\CrepMso5\Competences;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CrepMso5CompetenceTransverseType extends AbstractType
{
    /**
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('niveauAcquis', ChoiceType::class,
                        [
                            'choices' => [
                                '0' => 0,
                                '1' => 1,
                                '2' => 2,
                                '3' => 3,
                                '4' => 4,
                            ],
                            'expanded' => true,
                            'multiple' => false
                          ]);
    }

    /**
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso5\CrepMso5CompetenceTransverse'
        ));
    }
}