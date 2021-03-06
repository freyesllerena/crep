<?php

/**
 * Created by PhpStorm.
 * User: freyes-adc
 * Date: 10/07/2018
 * Time: 14:58
 */

namespace AppBundle\Form\Crep\CrepMj02\Formations;


use AppBundle\Entity\Crep\CrepMj02\CrepMj02;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CrepMj02FormationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', null, array(
                'attr' => array(
                    'class' => 'fieldCollection',
                    'maxlength' => '4096',
                ),
            ))
            ->add('objectif', null, [
                    'label' => false,
                    'required' => false,
                    ]
            )
            ->add('duree', null, [
                    'label' => false,
                    'required' => false,
                    ]
            )
            ->add('cpf', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'required' => false
            ])
            ->add(
                'typologie',
                ChoiceType::class,
                [
                    'label' => false,
                    'choices' => CrepMj02::$thematiquesFormationsCrepMj02,
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => ['style' => 'min-width: 280px;'],
                    'required' => false,
                    'placeholder' => '',
                ]
            )
            ->add('suivie', ChoiceType::class, [
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0,
                ],
                'expanded' => true,
                'multiple' => false,
                'placeholder' => false,
                'required' => false
            ])
            ->add('motifNonSuivie', TextareaType::class, array(
                'attr' => array(
                    'class' => 'fieldCollection',
                    'maxlength' => '4096',
                ),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Crep\CrepMj02\CrepMj02Formation',
            'annee_evaluee' => null,
        ));
    }
}