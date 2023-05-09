<?php

namespace App\Form;

use App\Entity\GraveType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GraveTypeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];

        $builder
            // Needed when form appear in the modal to find it on save.
            ->add('id', HiddenType::class,[
                'label' => 'Id'
            ])
            ->add('descriptionEs', null, [
                'label' => 'graveType.descriptionEs',
                'disabled' => $readonly,
            ])
            ->add('descriptionEu', null, [
                'label' => 'graveType.descriptionEu',
                'disabled' => $readonly,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GraveType::class,
            'readonly' => false,
        ]);
    }
}
