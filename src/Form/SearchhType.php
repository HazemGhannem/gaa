<?php

namespace App\Form;

use App\Classe\Searchh;

use App\Entity\Materiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchhType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'label' => 'Recherche',
                'required' => false,
                'attr' => [
                    'placeholder' => 'votre recherche ..',
                    'class' => 'rt-banner-searchbox flight-search'
                ]
            ])
            ->add('submit', SubmitType::class,
                [
                    'label' => 'Filtrer',
                    'attr' => [
                        'class' => 'rt-btn rt-gradient pill rt-sm3 text-uppercase rt-mt-10 btn-block'

                    ]
                ]
            );
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Searchh::class,
            'csrf_protection' => false,
        ]);
    }

}
