<?php

namespace App\Form;

//"Symfony\Component\Form\FormTypeInterface


use App\Entity\ReservationCompetition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationCompetitionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nbrparticipants')
            ->add('competition')
           /* ->add('nbrparticipants',IntegerType::class,array(
                'label'=>'nbrparticipants',
                'attr'=>array (
                    'class'=>"form-control mb-3"
                )
            ))


            ->add('competition',IntegerType::class,array(
                'label'=>'competition',
                'attr'=>array (
                    'class'=>"form-control mb-3"
                )
            ))*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReservationCompetition::class,
        ]);
    }
}
