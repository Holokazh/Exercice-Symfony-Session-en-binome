<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('OldPassword', PasswordType::class, ['label' => 'Mot passe actuel'])
            ->add('NewPassword', RepeatedType::class, [
                'type'              => PasswordType::class,
                'mapped'            => false,
                'first_options'     => array('label' => 'Nouveau mot de passe'),
                'second_options'    => array('label' => 'Confirmation du nouveau mot de passe'),
                'invalid_message' => 'Erreur de la confirmation du nouveau mot de passe.'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
