<?php

namespace App\Form;

use App\Entity\Adjudication;
use App\Entity\Grave;
use App\Entity\Owner;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdjudicationEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];
        $builder
            ->add('adjudicationYear', IntegerType::class,[ 
                'label' => 'adjudication.adjudicationYear',
                'disabled' => $readonly,
            ])
            ->add('expiryYear', IntegerType::class,[ 
                'label' => 'adjudication.expiryYear',
                'disabled' => $readonly,
            ])
            ->add('note',TextareaType::class,[ 
                'label' => 'adjudication.note',
                'disabled' => $readonly,
            ])
            ->add('registrationNumber', IntegerType::class,[ 
                'label' => 'adjudication.registrationNumber',
                'disabled' => $readonly,
            ])
            ->add('owner', EntityType::class,[
                'label' => 'adjudication.owner',
                'disabled' => $readonly,
                'class' => Owner::class,
            ])
            ->add('grave', EntityType::class,[
                'label' => 'adjudication.grave',
                'disabled' => $readonly,
                'class' => Grave::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adjudication::class,
            'readonly' => false,
        ]);
    }
}
