<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('roles')
            ->add('password', PasswordType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('birthDay', DateType::class)
            ->add('avatar', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('zipCode', TextType::class)
            ->add('Address', TextType::class)
            ->add('city', TextType::class)
            ->add('hiringDate', DateType::class)
            ->add('title', TextType::class)
            ->add('categories', TextType::class)
            ->add('valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
