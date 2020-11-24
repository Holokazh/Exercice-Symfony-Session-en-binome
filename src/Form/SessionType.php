<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbSpace', IntegerType::class, ['label' => 'Nombre de place'])
            ->add('dateStart', DateType::class, ['label' => 'Date de début', 'format' => 'ddMMyyyy',
             'years' => range(date("Y"), date("Y") + 5), 'months' => range(date("M"), 12), 'days' => range(date('D'), 31)])
            ->add('dateEnd', DateType::class, ['label' => 'Date de fin', 'format' => 'ddMMyyyy',
             'years' => range(date("Y"), date("Y") + 7), 'months' => range(date("M"), 12), 'days' => range(date('D'), 31)])
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'choice_label' => 'name',
                'label' => "Formation"
            ])
            // ->add('students')
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
