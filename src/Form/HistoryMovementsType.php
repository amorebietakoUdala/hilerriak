<?php

namespace App\Form;

use App\Entity\Cemetery;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class HistoryMovementsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $readonly = $options['readonly'];
        $locale = $options['locale'];
        $builder
        ->add('numRegistro', null, [
            'label' => 'historyMovement.numRegistro',
            'disabled' => $readonly,
            'required' => false,
        ])
        ->add('anyo', null, [
            'label' => 'historyMovement.anyo',
            'disabled' => $readonly,
            'required' => false,
        ])
        ->add('tipoAccion', null, [
            'label' => 'historyMovement.tipoAccion',
            'disabled' => $readonly,
            'required' => false,
        ])
        ->add('sepulturaDestino', null, [
            'label' => 'historyMovement.sepulturaDestino',
            'disabled' => $readonly,
            'required' => false,
        ])
        ->add('fechaRegistroFrom', null, [
            'label' => 'historyMovement.fechaRegistroFrom',
            'disabled' => $readonly,
            'required' => false,
        ])
        ->add('fechaRegistroTo', null, [
            'label' => 'historyMovement.fechaRegistroTo',
            'disabled' => $readonly,
            'required' => false,
        ])
        ->add('difunto', null, [
            'label' => 'historyMovement.difunto',
            'disabled' => $readonly,
            'required' => false,
        ])
        // ->add('Descripcion', null, [
        //     'label' => 'historyMovement.Descripción',
        //     'disabled' => $readonly,
        //     'required' => false,
        // ])
        ->add('origenRestos', null, [
            'label' => 'historyMovement.origenRestos',
            'disabled' => $readonly,
            'required' => false,
        ])
        // ->add('N_Expediente', null, [
        //     'label' => 'historyMovement.N_Expediente',
        //     'disabled' => $readonly,
        //     'required' => false,
        // ])
        // ->add('Incidencias', null, [
        //     'label' => 'historyMovement.Incidencias',
        //     'disabled' => $readonly,
        //     'required' => false,
        // ])
        ->add('cementerio', ChoiceType::class, [
            'label' => 'historyMovement.cementerio',
            'disabled' => $readonly,
            'placeholder' => 'label.choose',
            'required' => true,
            'choices' => [
                'ETXANO' => 'ETXANO',
                'LEGINETXE' => 'LEGINETXE',
            ],
            'constraints' => [
                new NotBlank(),
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
