<?php

namespace App\Form;

use App\Entity\DestinationType;
use App\Entity\Grave;
use App\Entity\Movement;
use App\Entity\MovementType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Positive;

class MovementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];
        $new = $options['new'];
        $locale = $options['locale'];
        $builder
            ->add('petitioner', PetitionerFormType::class, [
                'label' => false,
                'readonly' => $readonly,
            ])
            ->add('type', EntityType::class,[
                'class' => MovementType::class,
                'label' => 'movement.type',
                'disabled' => $readonly,
                'required' => true,
                'choice_label' => function (MovementType $movementType) use ($locale) {
                    return $movementType->getDescription($locale);
                }                
            ])
            ->add('source', EntityType::class,[
                'class' => Grave::class,
                'label' => 'movement.source',
                'disabled' => $readonly,
                'required' => false,
                'placeholder' => '',
                'choice_label' => function (Grave $grave) {
                    return $grave->getCodeCemetery();
                }                
            ])
            ->add('destinationType', EntityType::class,[
                'class' => DestinationType::class,
                'label' => 'movement.destinationType',
                'disabled' => $readonly,
                'required' => true,
                'placeholder' => 'label.choose',
                'choice_label' => function (DestinationType $destinationType) use ($locale) {
                    return $destinationType->getDescription($locale);
                }                
            ])
            ->add('destination', EntityType::class,[
                'class' => Grave::class,
                'label' => 'movement.destination',
                'disabled' => $readonly,
                'required' => false,
                'placeholder' => 'label.choose',
                'choice_label' => function (Grave $grave) {
                    return $grave->getCodeCemetery();
                }                
            ])
            ->add('wantsToBePresent', null,[
                'label' => 'movement.wantsToBePresent',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('registrationNumber', IntegerType::class,[
                'label' => 'movement.registrationNumber',
                'disabled' => $readonly,
                'required' => true,
                'constraints' => [
                    new Positive(),
                ]
            ])
            ->add('defunctName', null,[
                'label' => 'movement.defunctName',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('defunctSurname1', null,[
                'label' => 'movement.defunctSurname1',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('defunctSurname2', null,[
                'label' => 'movement.defunctSurname2',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('relationship', null,[
                'label' => 'movement.relationship',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('deceaseDate', DateType::class, [
                'label' => 'movement.deceaseDate',
                'disabled' => $readonly,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd',
                'required' => false,
            ])
            ->add('note',TextareaType::class,[ 
                'label' => 'movement.note',
                'disabled' => $readonly,
                'required' => false,
            ])
        ;
        if ( !$new ) {
            $builder
            ->add('finalized', CheckboxType::class,[
                'label' => 'movement.finalized',
                'disabled' => $readonly,
                'required' => false,
            ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movement::class,
            'readonly' => false,
            'new' => false,
            'locale' => 'es',
        ]);
    }
}
