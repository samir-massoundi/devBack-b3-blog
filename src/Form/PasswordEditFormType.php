<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, 
            [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être indentiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' =>true,
                'first_options' =>['label'=> 'Mot de passe'],
                'second_options' =>['label'=> 'Repeter le mot de passe'],
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
