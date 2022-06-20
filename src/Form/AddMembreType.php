<?php

namespace App\Form;

use App\Entity\Membre;
use App\Entity\Year;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddMembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//         dd($options['data']->getPhoto());
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('pole')
            ->add('lienfb',TextType::class,['required'=>false])
            ->add('lienInsta',TextType::class,['required'=>false])
            ->add('lienlinkedin',TextType::class,['required'=>false])
            ->add('rang')
            ->add('autre',TextType::class,['required'=>false])
            ->add('year',EntityType::class,[
                'class' => Year::class,
                'placeholder' =>'Choisir l\'année',
                'required' => false,
                //                 'choice_value'=> function(?Membre $membre){return $membre ? $membre->getId() : '';},
                'choice_label' =>function($year){
                return ($year->getNom().' '.$year->getYear());}
            ]);
            if($options['data']){
                $builder->add('photo', FileType::class, array('required'=>false, 'mapped' => false));
            }else{
                $builder->add('photo', FileType::class);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
