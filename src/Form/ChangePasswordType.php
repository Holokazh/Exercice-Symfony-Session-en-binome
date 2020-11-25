<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'label' => 'Mot passe actuel',
                'mapped' => false,
            ])
            ->add('newPassword', RepeatedType::class, [
                'type'              => PasswordType::class,
                'mapped'            => false,
                'first_options'     => array('label' => 'Nouveau mot de passe'),
                'second_options'    => array('label' => 'Confirmation du nouveau mot de passe'),
                'invalid_message' => 'Erreur de la confirmation du nouveau mot de passe.',
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => "Veuillez mettre plus de {{ limit }} caractère(s)",
                        'max' => 15,
                        'maxMessage' => 'Veuillez mettre moins de {{ limit }} caractère(s)'
                    ]),
                    // new Regex([
                    //     'pattern' => "/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{​​​​2,4}​​​​$/i",
                    //     'match' => true,
                    //     'message' => "Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole."
                    // ])
                ]
            ])
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
