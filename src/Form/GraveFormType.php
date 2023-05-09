<?php

namespace App\Form;

use App\Entity\Grave;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GraveFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];
        $builder
            ->add('cemetery', null, [
                'label' => 'grave.cemetery',
                'disabled' => $readonly,
                'required' => true,
            ])
            ->add('type', null, [
                'label' => 'grave.type',
                'disabled' => $readonly,
                'required' => true,
            ])
            ->add('code', null, [
                'label' => 'grave.code',
                'disabled' => $readonly,
                'required' => true,
            ])
            ->add('years', null, [
                'label' => 'grave.years',
                'disabled' => $readonly,
                'required' => true,
            ])
            ->add('free', CheckboxType::class, [
                'label' => 'grave.free',
                'disabled' => $readonly,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Grave::class,
            'readonly' => false,
            'new' => false,
        ]);
    }
}
