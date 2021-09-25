<?php

namespace App\Form;

use App\Entity\Club;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Membre;

class AddClubType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('texte')
            ->add('pres', EntityType::class, [
                'class' => Membre::class,
                'choice_label' =>function($membre){
                return ($membre->getNom().' '.$membre->getPrenom().' '.$membre->getId());},
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ]);
            if($options['data']){
                $builder->add('photo', FileType::class, array('required'=>false, 'mapped' => false));
            }else{
                $builder->add('photo', FileType::class, array());
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Club::class,
        ]);
    }
}
