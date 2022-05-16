<?php

namespace App\Form;

use App\Entity\Adresse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'label' => 'nom de votre adresse',
                'attr' => [
                    'placeholder' => 'saisir le nom de votre adresse'
                ]
            ])
            ->add('firstname',TextType::class, [
                'label' => 'votre prénom',
                'attr' => [
                    'placeholder' => 'saisir votre prenom'
                ]
            ])
            ->add('lastname',TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'saisir votre nom'
                ]
            ])
            ->add('adress',TextType::class, [
                'label' => 'votre adresse',
                'attr' => [
                    'placeholder' => 'saisir votre adresse'
                ]
            ])
            ->add('postal',TextType::class, [
                'label' => 'votre code postal',
                'attr' => [
                    'placeholder' => 'saisir le code postal'
                ]
            ])
            ->add('ville',TextType::class, [
                'label' => 'votre ville',
                'attr' => [
                    'placeholder' => 'saisir votre ville'
                ]
            ])
            ->add('phone',TelType::class, [
                'label' => 'votre telephone',
                'attr' => [
                    'placeholder' => 'saisir le numéro de téléphone'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label' => 'Valider',
                'attr' => [
                    'class' => 'rt-btn rt-gradient pill rt-sm3 text-uppercase rt-mt-10 btn-block'
                ]
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresse::class,
        ]);
    }
}
