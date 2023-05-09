<?php

namespace App\Form;

use App\Entity\Cemetery;
use App\Entity\GraveType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GraveSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];
        $locale = $options['locale'];
        $builder
            ->add('code', null, [
                'label' => 'grave.code',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('years', null, [
                'label' => 'grave.years',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('free', ChoiceType::class, [
                'label' => 'grave.free',
                'disabled' => $readonly,
                'required' => false,
                'choices' => [
                    'label.yes' => true,
                    'label.no' => false,
                ],
            ])
            ->add('cemetery', EntityType::class, [
                'class' => Cemetery::class,
                'label' => 'grave.cemetery',
                'disabled' => $readonly,
                'placeholder' => '',
                'required' => false,
            ])
            ->add('type', EntityType::class, [
                'class' => GraveType::class,
                'label' => 'grave.type',
                'disabled' => $readonly,
                'placeholder' => '',
                'choice_label' => function ($graveType) use ($locale) {
                    return $graveType->getDescription($locale);
                },
                'required' => false,                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'readonly' => false,
            'new' => false,
            'locale' => 'es',
        ]);
    }
}
