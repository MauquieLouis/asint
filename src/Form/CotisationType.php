<?php

namespace App\Form;

use App\Entity\Cotisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;

class CotisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        //Nom, Pr�nom, Date de naissance, TSP ou IMT-BS, ann�e(1A, 2A, 3A, bachelor), num�ro de t�l�phone, salle, mail �cole, sports souhait�s, soge ou pas, si soge demande du num�ro de remise(option � venir)
        ->add('nom', TextType::class)
        ->add('prenom', TextType::class)
        ->add('naissance', DateType::class, [
            'widget' => 'choice',
            'format' => 'ddMMyyyy',
            'years' => range(date('Y'), date('Y')-50),
            'months' => range(1, 12),
            'days' => range(1, 31),
        ])
        
        ->add('ecole', ChoiceType::class, [
            'choices'  => [
                'TSP' => 'TSP',
                'IMT-BS' => 'IMT-BS',
            ],
        ])
        
        ->add('niveau', ChoiceType::class, [
            'choices'  => [
                '1A' => '1A',
                '2A' => '2A',
                '3A' => '3A',
                // if ($this->ecole == 'bs') {
                'Bachelor' => 'bachelor',
                // }
            ],
        ])
        ->add('telephone', TextType::class)
        ->add('mailEcole', EmailType::class)
        
        ->add('sports', TextType::class,['label' => 'Sports souhaités'])
        
        ->add('duree', ChoiceType::class, [
            'choices'  => [
                '3 ans' => 1,
                '1 an' => 2,
                '6 mois' => 3,
                
            ],
        ])
        
        ->add('optionSalle', ChoiceType::class, [
            'choices'  => [
                'Non' => false,
                'Oui' => true,
            ],
            'label' => 'Option salle de sport',
        ])
        
        ->add('remiseSoge', ChoiceType::class, [
            'choices'  => [
                'Non' => false,
                'Oui' => true,
            ],
            'label' => 'Remise Société Générale',
        ])
        // if ($this->soge == 'true') {
        //     ->add('numsoge', TextType::class)
        // }
        
        ->add('Valider', SubmitType::class);
        ;
        
        
        
        $builder->get('naissance')->addModelTransformer(new CallbackTransformer(
            function ($value) {
                if(!$value) {
                    return new \DateTime('now -20 year');
                }
                return $value;
            },
            function ($value) {
                return $value;
            }
            ));
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cotisation::class,
        ]);
    }
}
