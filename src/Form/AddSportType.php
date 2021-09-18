<?php

namespace App\Form;

use App\Entity\Sport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Membre;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddSportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('texte',TextType::class,['required'=>false])
            ->add('responsable', EntityType::class,[
                'class' => Membre::class,
                'placeholder' =>'Choisir le respo',
                'required' => false,
//                 'choice_value'=> function(?Membre $membre){return $membre ? $membre->getId() : '';},
                'choice_label' =>function($membre){
                    return ($membre->getNom().' '.$membre->getPrenom().' '.$membre->getId());}
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
            'data_class' => Sport::class,
        ]);
    }
}
