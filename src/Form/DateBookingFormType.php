<?php

namespace App\Form;

use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DateBookingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'label' => 'Date',
                'attr'  => ['min' => date('Y-m-d')],
            ])
            ->add('hour', ChoiceType::class, [
                'choices'  => [
                    'Midi' => [
                        '12h' => 12,
                        '13h' => 13,
                    ],
                    'Soir' => [
                        '19h' => 19,
                        '20h' => 20,
                    ]
                ],
                'label' => 'Heure',
            ])
            ->add('minutes', ChoiceType::class, [
                'choices'  => [
                    '00' => 00,
                    '15' => 15,
                    '30' => 30,
                    '45' => 45,
                ],
                'label' => 'Minutes',
            ])
            ->add('nbGuests', IntegerType::class, ['attr' => ['min' => 1], 'label' => 'Nombre de couverts'])
            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn-outline-success '], 'label' => 'Rechercher'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
