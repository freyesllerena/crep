<?php

namespace AppBundle\Form\Crep\CrepMso5;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Form\ObjectifEvalueParentType;

class CrepMso5ObjectifEvalueCollectifType extends ObjectifEvalueParentType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMso5\CrepMso5ObjectifEvalueCollectif',
            'echelleObjectifEvalue' => null,
        ));
    }
}
