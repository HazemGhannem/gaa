<?php

namespace App\Form;

use App\Entity\Competition;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetitionType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom', TextType::class, array(
                'label' => 'Nom',
                'attr' => array(
                    'class'=> "form-control mb-3"
                )
            ))
            ->add('description', TextType::class, array(
                'label' => 'Description',
                'attr' => array(
                    'class'=> "form-control mb-3"
                )
            ))
            ->add('category', TextType::class, array(
                'label' => 'Categorie',
                'attr' => array(
                    'class'=> "form-control mb-3"
                )
            ))
            ->add('nombre_de_place', IntegerType::class, array(
                'label' => 'Nombre de place',
                'attr' => array(
                    'class'=> "form-control mb-3"
                )
            ))
            ->add('image', TextType::class, array(
                'label' => 'Image url',
                'attr' => array(
                    'class'=> "form-control mb-3"
                )
            ))
            ->add('adresse', TextType::class, array(
                'label' => 'Adresse',
                'attr' => array(
                    'class'=> "form-control mb-3"
                )
            ))
            ->add('date')
        ;


    /*
        r->add('subject', 'text', array(
            'label'  => 'Subject',
            'attr'   =>  array(
                'class'   => 'c4')
        )
    );
    */

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Competition::class,
        ]);
    }
}
