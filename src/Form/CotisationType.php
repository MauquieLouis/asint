<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\ChoiceList\ChoiceList;

use Symfony\Component\Form\CallbackTransformer;


class CotisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //Nom, Prénom, Date de naissance, TSP ou IMT-BS, année(1A, 2A, 3A, bachelor), numéro de téléphone, salle, mail école, sports souhaités, soge ou pas, si soge demande du numéro de remise(option à venir)
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
                    'TSP' => 1,
                    'IMT-BS' => 2,
                ],
            ])
            
            ->add('niveau', ChoiceType::class, [
                'choices'  => [
                    '1A' => 1,
                    '2A' => 2,
                    '3A' => 3,
                    // if ($this->ecole == 'bs') {
                    'Bachelor' => 4,
                    // }
                ],
            ])
            ->add('telephone', TextType::class)
            ->add('mailEcole', EmailType::class)

            ->add('sportsSouhaites', TextType::class)

            ->add('duree', ChoiceType::class, [
                'choices'  => [
                    '3 ans' => 1,
                    '1 an' => 2,
                    '6 mois' => 3,

                ],
            ])

            ->add('optionSalle', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])

            ->add('remiseSocieteGenerale', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false,
                ],
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
}
