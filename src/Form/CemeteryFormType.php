<?php

namespace App\Form;

use App\Entity\Cemetery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CemeteryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];

        $builder
            // Needed when form appear in the modal to find it on save.
            ->add('id', HiddenType::class, [
                'label' => 'Id',
            ])
            ->add('name', null, [
                'label' => 'cemetery.name',
                'disabled' => $readonly,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cemetery::class,
            'readonly' => false,
        ]);
    }
}
