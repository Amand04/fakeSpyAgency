<?php

namespace App\Form;

use App\Entity\Targets;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TargetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['label' => 'Prénom'])
            ->add('birthdayDate', BirthdayType::class, ['label' => 'Date de naissance'])
            ->add('nameCode', TextType::class, ['label' => 'Nom de code'])
            ->add('nationality', ChoiceType::class, [
                'choices' => [
                    'Afrique du sud' => 'Afrique du sud',
                    'Allemagne' => 'Allemagne',
                    'Argentine' => 'Argentine',
                    'Belgique' => 'Belgique',
                    'Brésil' => 'Brésil',
                    'Chine' => 'Chine',
                    'Corée' => 'Corée',
                    'Croatie' => 'Croatie',
                    'Etats-Unis' => 'Etats-Unis',
                    'France' => 'France',
                    'Irlande' => 'Irlande',
                    'Japon' => 'Japon',
                    'Maroc' => 'Maroc',
                    'Norvege' => 'Norvege',
                    'Portugal' => 'Portugal',
                    'Royaume-uni' => 'Royaume-uni',
                    'Russie' => 'Russie',
                    'Tunisie' => 'Tunisie',
                    'Ukraine' => 'Ukraine',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Targets::class,
        ]);
    }
}
