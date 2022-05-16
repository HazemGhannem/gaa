<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class InscriptionAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class ,
                [
                    'label'=>'Votre prénom' ,
                    'required'=> true ,
                    'constraints' => new Length([
                        'min'=>2,
                        'max' =>30
                    ]),
                    'attr' =>[
                        'placeholder'=>'Merci de saisir votre prenom'
                    ]
                ] )
            ->add('lastname',TextType::class ,
                [
                    'label'=>'Votre nom' ,
                    'required'=> true ,
                    'constraints' => new Length([
                        'min'=>2,
                        'max' =>30
                    ]),
                    'attr' =>[
                        'placeholder'=>'Merci de saisir votre nom'
                    ]
                ])
            ->add('email',EmailType::class ,[
                'label'=>'Votre email' ,
                'required'=> true ,
                'constraints' => new Length([
                    'min'=>2,
                    'max' =>30
                ]),
                'attr' =>[
                    'placeholder'=>'Merci de saisir votre email'
                ]
            ])


            ->add('password',RepeatedType::class , array(
                'type'=> PasswordType::class,
                'invalid_message' => 'le mot de passe et la confirmation doivent etre identique',
                'label'=>'Votre mot de passe' ,
                'required'=> true,

                'first_options'=>
                    array(
                        'label' => 'Mot de passe',
                        'attr' => array(
                            'placeholder'=>'Merci de saisir votre mot de passe'

                        )
                    ),
                'second_options'=> array(
                    'label' => 'Confirmer vote de passe',
                    'attr' => array(
                        'placeholder'=>'Merci de confirmer votre mot de passe'
                    )
                )


            ))

            ->add('submit',SubmitType::class, array(
                    'label'=>"S'inscrire")
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
