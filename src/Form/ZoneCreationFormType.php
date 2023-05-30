<?php

namespace App\Form;

use App\Entity\Cemetery;
use App\Entity\GraveType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ZoneCreationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $locale = $options['locale'];
        $builder
            ->add('letter', null, [
                'label' => 'sideCreationForm.letter'
            ])
            ->add('zone', IntegerType::class, [
                'label' => 'sideCreationForm.zone',
                'required' => false,
            ])
            ->add('high', IntegerType::class, [
                'label' => 'sideCreationForm.high'
            ])
            ->add('width', IntegerType::class, [
                'label' => 'sideCreationForm.width'
            ])
            ->add('years', IntegerType::class, [
                'label' => 'sideCreationForm.years'
            ])
            ->add('type', EntityType::class, [
                'label' => 'grave.type',
                'class' => GraveType::class,
                'choice_label' => function (GraveType $graveType) use ($locale) {
                    return $graveType->getDescription($locale);
                }                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'locale' => 'es',
        ]);
    }
}
