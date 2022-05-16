<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idOrganisateur',IntegerType::class,[ 'label' => 'Identifiant de l\'organisateur'])
            ->add('titre',TextType::class,[ 'label' => 'Le titre de l\'événement'])
            ->add('dateDebut',DateType::class,[ 'label' => 'Date debut'])
            ->add('dateFin',DateType::class,[ 'label' => 'Date fin'])
            ->add('heure')
            ->add('ville',TextType::class,[ 'label' => 'Ville de l\'événement'])
            ->add('adresse',TextType::class,[ 'label' => 'L\'adresse'])
            ->add('description',TextType::class,[ 'label' => 'Description de l\'événement'])
            ->add('photo',FileType::class ,array('data_class' => null))
            ->add('approuver',ChoiceType::class,[
        'choices'=>['Oui'=>'1', 'Non'=>'0'],'label' => 'Approuvé par l\'admin'])
            ->add('nombreVus',IntegerType::class,['disabled' => true,'label' => 'Nombre de vus '])
            ->add('nombreParticipants',IntegerType::class,['disabled' => true,'label' => 'Nombre de participants'])
            ->add('nombreMax',IntegerType::class,[ 'label' => 'Nombre maximale des participants'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
