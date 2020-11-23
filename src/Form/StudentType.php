<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                ],
                'label' => 'Civilité'
            ])

            ->add('firstName', TextType::class, ['label' => 'Prénom'])

            ->add('lastName', TextType::class, ['label' => 'Nom'])

            ->add('birthDay', BirthdayType::class, ['label' => 'Date de naissance', 'format' => 'ddMMyyyy', 'years' => range(date("Y") - 18, date("Y") - 120)])

            ->add('email', EmailType::class, ['label' => 'Adresse email'])

            ->add('city', TextType::class, ['label' => 'Ville'])

            ->add('phoneNumber', TextType::class, ['label' => 'Téléphone'])

            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
