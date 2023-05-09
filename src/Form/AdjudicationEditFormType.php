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
            ->add('decreeDate', DateType::class,[
                'label' => 'adjudication.decreeDate',
                'disabled' => $readonly,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'required' => false,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('expiryYear', IntegerType::class,[ 
                'label' => 'adjudication.expiryYear',
                'disabled' => $readonly,
            ])
            ->add('note',TextareaType::class,[ 
                'label' => 'adjudication.note',
                'disabled' => $readonly,
            ])
            ->add('renewed', CheckboxType::class,[ 
                'label' => 'adjudication.renewed',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('expedientNumber',null,[ 
                'label' => 'adjudication.expedientNumber',
                'disabled' => $readonly,
            ])
            ->add('registrationNumber', IntegerType::class,[ 
                'label' => 'adjudication.registrationNumber',
                'disabled' => $readonly,
            ])
            ->add('current', CheckboxType::class,[ 
                'label' => 'adjudication.current',
                'disabled' => $readonly,
                'required' => false,
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
