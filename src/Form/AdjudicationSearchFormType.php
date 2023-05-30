<?php

namespace App\Form;

use App\Entity\Cemetery;
use App\Entity\Grave;
use App\Entity\Owner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdjudicationSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cemetery', EntityType::class,[
                'label' => 'adjudication.cemetery',
                'class' => Cemetery::class,
                'placeholder' => 'label.choose',
                'required' => false,
            ])
            ->add('owner', EntityType::class,[
                'label' => 'adjudication.owner',
                'class' => Owner::class,
                'placeholder' => '',
                'required' => false,
            ])
            ->add('grave', EntityType::class,[
                'label' => 'adjudication.grave',
                'class' => Grave::class,
                'placeholder' => '',
                'required' => false,
            ])
            ->add('expired', ChoiceType::class,[
                'label' => 'adjudication.expired',
                'required' => false,
                'placeholder' => '',
                'choices' => [
                    'label.yes' => true,
                    'label.no' => false,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
