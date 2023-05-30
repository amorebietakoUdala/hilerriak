<?php

namespace App\Form;

use App\Entity\Cemetery;
use App\Entity\Grave;
use App\Entity\Owner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdjudicationAddFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cemetery', EntityType::class,[
                'label' => 'adjudication.cemetery',
                'class' => Cemetery::class,
                'placeholder' => 'label.choose',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('owner', EntityType::class,[
                'label' => 'adjudication.owner',
                'class' => Owner::class,
                'placeholder' => '',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('grave', EntityType::class,[
                'label' => 'adjudication.grave',
                'class' => Grave::class,
                'placeholder' => '',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('registrationNumber', IntegerType::class,[ 
                'label' => 'adjudication.registrationNumber',
                'required' => true,
            ])
            // ->add('addMovement', HiddenType::class,[
            //     'required' => false,
            //     'empty_data' => 0,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
