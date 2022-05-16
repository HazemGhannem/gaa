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

class InscriptionType extends AbstractType
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
            ->add('sexe', ChoiceType::class, [
                'choices'  => [
                    'feminin' => 'feminin',
                    'masculin' => 'masculin' ,
                    'autre' => 'autre',
                ],
            ])
            ->add('age', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class, [
                'label'=>'Votre age' ,
                'required'=> true ,
                'constraints' => new Length([
                    'min'=>2,
                    'max' =>30
                ])

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
            ->add('password',RepeatedType::class ,[
                'type'=> PasswordType::class,
                'invalid_message' => 'le mot de passe et la confirmation doivent etre identique',
                'label'=>'Votre mot de passe' ,
                'required'=> true,

                'first_options'=>
                    [
                    'label' => 'Mot de passe',
                    'attr' =>[
                        'placeholder'=>'Merci de saisir votre mot de passe'

                    ]
                    ],
                'second_options'=> [
                    'label' => 'Confirmer vote de passe',
                    'attr' =>[
                        'placeholder'=>'Merci de confirmer votre mot de passe'
                    ]
                ]



            ])

            ->add('submit',SubmitType::class,[
                'label'=>"S'inscrire" ]
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
