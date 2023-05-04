<?php

namespace App\Form;

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
                        '12h00' => '12:00',
                        '12h15' => '12:15',
                        '12h30' => '12:30',
                        '12h45' => '12:45',
                        '13h00' => '13:00',
                        '13h15' => '13:15',
                        '13h30' => '13:30',
                        '13h45' => '13:45',
                    ],
                    'Soir' => [
                        '19h00' => '19:00',
                        '19h15' => '19:15',
                        '19h30' => '19:30',
                        '19h45' => '19:45',
                        '20h00' => '20:00',
                        '20h15' => '20:15',
                        '20h30' => '20:30',
                        '20h45' => '20:45',
                    ]
                ],
                'label' => 'Heure',
            ])
            ->add('nbGuests', IntegerType::class, [
                'attr' => ['min' => 1], 
                'label' => 'Nombre de couverts'
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn-outline-success '], 
                'label' => 'Rechercher'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'task_item',
        ]);
    }
}
