<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $builder
        ->add('username', TextType::class, [
            'label' => 'Nom d’utilisateur',
            'attr' => ['class' => 'form-control'],
            'required' => true,
        ])
        ->add('email', EmailType::class, [
            'label' => 'Adresse email',
            'attr' => ['class' => 'form-control'],
        ])
        ->add('Password', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'required' => true,
            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'form-control'],
            ],
            'second_options' => [
                'label' => 'Confirmez le mot de passe',
                'attr' => ['class' => 'form-control'],
            ],
        ]);
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Lie le formulaire à l'entité User
        ]);
    }
}
