<?php

namespace App\Form;

use App\Entity\Cemetery;
use App\Entity\GraveType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('high', null, [
                'label' => 'sideCreationForm.high'
            ])
            ->add('width', null, [
                'label' => 'sideCreationForm.width'
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
