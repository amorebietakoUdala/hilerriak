<?php

namespace App\Form;

use App\Entity\DestinationType;
use App\Entity\Grave;
use App\Entity\MovementType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class MovementSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];
        $locale = $options['locale'];
        $builder
            ->add('type', EntityType::class,[
                'class' => MovementType::class,
                'label' => 'movement.type',
                'disabled' => $readonly,
                'required' => false,
                'choice_label' => fn(MovementType $movementType) => $movementType->getDescription($locale)                
            ])
            ->add('source', EntityType::class,[
                'class' => Grave::class,
                'label' => 'movement.source',
                'disabled' => $readonly,
                'required' => false,
                'placeholder' => '',
                'choice_label' => fn(Grave $grave) => $grave->getCodeCemetery()                
            ])
            ->add('destinationType', EntityType::class,[
                'class' => DestinationType::class,
                'label' => 'movement.destinationType',
                'disabled' => $readonly,
                'required' => false,
                'placeholder' => '',
                'choice_label' => fn(DestinationType $destinationType) => $destinationType->getDescription($locale)                
            ])
            ->add('destination', EntityType::class,[
                'class' => Grave::class,
                'label' => 'movement.destination',
                'disabled' => $readonly,
                'required' => false,
                'placeholder' => '',
                'choice_label' => fn(Grave $grave) => $grave->getCodeCemetery()                
            ])
            ->add('registrationNumber', IntegerType::class,[
                'label' => 'movement.registrationNumber',
                'disabled' => $readonly,
                'required' => false,
                'constraints' => [
                    new Positive(),
                ]
            ])
            ->add('defunctFullname', null,[
                'label' => 'movement.defunctFullname',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('movementDateFrom', DateType::class, [
                'label' => 'movement.movementDateFrom',
                'disabled' => $readonly,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ])
            ->add('movementDateTo', DateType::class, [
                'label' => 'movement.movementDateTo',
                'disabled' => $readonly,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ])
            ->add('finalized', ChoiceType::class,[
                'label' => 'movement.finalized',
                'disabled' => $readonly,
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
            'readonly' => false,
            'locale' => 'es',
        ]);
    }
}
