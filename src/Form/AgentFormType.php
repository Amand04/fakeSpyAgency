<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\Skills;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AgentFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, ['constraints' => [new Length(['min' => 2])]], ['label' => 'Nom'])
            ->add('firstname', TextType::class, ['constraints' => [new Length(['min' => 2])]], ['label' => 'Prénom'])
            ->add('birthdayDate', BirthdayType::class, ['label' => 'Date de naissance'])
            ->add('code', TextType::class, ['constraints' => [new Length(['min' => 2])]], ['label' => 'Code d\'identification'])
            ->add('nationality', ChoiceType::class, [
                'label' => 'Nationalité',
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
            ->add(
                'skills',
                EntityType::class,
                [
                    'class' => Skills::class,
                    'choice_label' => 'name',
                    'multiple' => true, 'expanded' => true
                ]
            );
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agents::class,
        ]);
    }
}
