<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('date', DateType::class,[
            'attr' => ['class' => 'form-control js-datepicker'],
            'required' => true,
            'label' => 'Date de resa',
            'widget' => "single_text",
            'html5' => FALSE,
            'format' => 'dd/MM/yyyy'
        ])
        ->add('quantity', IntegerType::class)
        ->add('submit', SubmitType::class, [
            'label' => 'soumettre',
            'attr' => [
                'class' => 'btn-block btn-primary'
            ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
