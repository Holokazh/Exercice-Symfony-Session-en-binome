<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('email', EmailType::class, ['label' => 'Adresse email'])
        // ->add('roles')
        ->add('password', RepeatedType::class, [
            'type'              => PasswordType::class,
            'mapped'            => false,
            'first_options'     => array('label' => 'Mot de passe'),
            'second_options'    => array('label' => 'Confirmation du mot de passe'),
            'invalid_message' => 'Erreur de la confirmation du mot de passe.'
        ])
        ->add('title', ChoiceType::class, [
            'choices' => [
                'M.' => 'M.',
                'Mme.' => 'Mme.',
            ],
            'label' => 'Civilité'
        ])
        ->add('firstName', TextType::class, ['label' => 'Prénom'])
        ->add('lastName', TextType::class, ['label' => 'Nom'])
        ->add('birthDay', DateType::class, ['label' => 'Date de naissance', 'format' => 'ddMMyyyy', 'years' => range(date("Y") - 18, date("Y") - 120)])
        ->add('Address', TextType::class, ['label' => 'Numéro de voie et nom de la rue'])
        ->add('zipCode', TextType::class, ['label' => 'Code postal'])
        ->add('city', TextType::class, ['label' => 'Ville'])
        ->add('phoneNumber', TextType::class, ['label' => 'Numéro de téléphone'])
        ->add('avatar', TextType::class, ['label' => 'Image de profil'])
        ->add('hiringDate', DateType::class, ['label' => 'Date d\'entrée chez V-B Formation', 'format' => 'ddMMyyyy', 'years' => range(date("Y"), date("Y") - 120)])
        // ->add('categories', ChoiceType::class, ['label' => 'Catégorie'])
        ->add('valider', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
