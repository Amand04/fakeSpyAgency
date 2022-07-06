<?php

namespace App\Form;

use App\Entity\Hideout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class HideoutFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, ['constraints' => [new Length(['min' => 2])]], ['label' => 'Code'])
            ->add('adress', TextType::class, ['constraints' => [new Length(['min' => 5])]], ['label' => 'Adresse'])
            ->add('country', ChoiceType::class, [
                'label' => 'Pays',
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
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Loft' => 'Loft',
                    'Appartement' =>  'Appartement',
                    'Maison' => 'Maison',
                    'Squat' => 'Squat',
                    'Villa' => 'Villa',
                    'Studio' => 'Studio',
                    'Fourgon' => 'Fourgon',
                    'Parc' => 'Parc',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hideout::class,
        ]);
    }
}
