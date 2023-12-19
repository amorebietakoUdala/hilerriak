<?php

namespace App\Form;

use App\Entity\Owner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OwnerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];
        $new = $options['new'];
        $builder
            ->add('dni', null, [
                'label' => 'owner.dni',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('name', null, [
                'label' => 'owner.name',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('surname1', null, [
                'label' => 'owner.surname1',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('surname2', null, [
                'label' => 'owner.surname2',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('telephone', null, [
                'label' => 'owner.telephone',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('email', null, [
                'label' => 'owner.email',
                'disabled' => $readonly,
                'required' => false,
            ]);
            if (!$new) {
                $builder->add('fullname', null, [
                    'label' => 'owner.fullName',
                    'disabled' => $readonly,
                    'required' => false,
                ]);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Owner::class,
            'readonly' => false,
            'new' => false,
        ]);
    }
}
