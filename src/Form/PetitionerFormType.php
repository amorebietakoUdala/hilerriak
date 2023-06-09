<?php

namespace App\Form;

use App\Entity\Petitioner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PetitionerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];
        $fullname = $options['fullname'];
        $new = $options['new'];
        $builder
            ->add('dni', null, [
                'label' => 'petitioner.dni',
                'disabled' => $readonly,
                'required' => !$new ? false : true,
            ])
            ->add('name', null, [
                'label' => 'petitioner.name',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('surname1', null, [
                'label' => 'petitioner.surname1',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('surname2', null, [
                'label' => 'petitioner.surname2',
                'disabled' => $readonly,
                'required' => false,
            ])
            ->add('telephone', null, [
                'label' => 'petitioner.telephone',
                'disabled' => $readonly,
                'required' => !$new ? false : true,
            ])
            ->add('email', null, [
                'label' => 'petitioner.email',
                'disabled' => $readonly,
                'required' => false,
            ])
        ;
        if ($fullname) {
            $builder->add('fullname', null, [
                'label' => 'petitioner.fullName',
                'disabled' => $readonly,
                'required' => false,
            ]);    
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Petitioner::class,
            'inherit_data' => false,
            'fullname' => false,
            'readonly' => false,
            'new' => false,
        ]);
    }
}
