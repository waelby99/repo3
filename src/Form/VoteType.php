<?php

namespace App\Form;

use App\Entity\Vote;
use App\Entity\Joueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\Extension\Core\Type\DateType;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de vote',
                'data' => new \DateTime(date('Y-m-d H:i:s'))
            ]) 
            ->add('joueurs', EntityType::class, [
                'class'=>Joueur::class,
                'choice_label'=>'nom',
                'multiple'=>true,
                'expanded'=>false,
                ])
                ->add('notevote', ChoiceType::class, [
                    'choices' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                    ],
                    'expanded' => true,
                    'multiple' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
        ]);
    }
}
