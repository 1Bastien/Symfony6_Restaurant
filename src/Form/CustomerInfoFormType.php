<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CustomerInfoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'label' => 'Mail',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer votre email.",
                    ])
                ]
            ])
            ->add('firstname', null, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer votre prénom.",
                    ])
                ]
            ])
            ->add('lastname', null, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => "Merci d'entrer votre nom.",
                    ])
                ]
            ])
            ->add('nbGuests', null, [
                'label' => 'Nombre de personne(s) par défaut',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
