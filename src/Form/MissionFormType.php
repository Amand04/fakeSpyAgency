<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\Contacts;
use App\Entity\Hideout;
use App\Entity\Missions;
use App\Entity\Skills;
use App\Entity\Targets;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('title', TextType::class, ['label' => 'Titre'])

            ->add('description', TextareaType::class, ['label' => 'Description'])

            ->add('nameCode', TextType::class, ['label' => 'Nom de code'])

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
                    'Infiltration' => 'Infiltration',
                    'Surveillance' =>  'Surveillance',
                    'Espionnage' => 'Espionnage',
                    'Assassinat' => 'Assassinat',
                ]
            ])

            ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En préparation' => 'En préparation',
                    'En cours' =>  'En cours',
                    'Terminé' => 'Terminé',
                    'Echec' => 'Echec',
                ]
            ])

            ->add(
                'speciality',
                EntityType::class,
                [
                    'mapped' => false, 'class' => Skills::class,
                    'choice_label' => function ($skill) {
                        return $skill->getName();
                    }, 'label' => 'Spécialité',
                    'multiple' => true, 'expanded' => true
                ]
            )

            ->add(
                'created_at',
                DateType::class,
                [
                    'label' => 'Date de début',
                    'widget' => 'choice',
                    'years' => range(date('Y'), 2060)
                ]
            )

            ->add(
                'closed_at',
                DateType::class,
                [
                    'label' => 'Date de fin',
                    'widget' => 'choice',
                    'years' => range(date('Y'), 2060)
                ]
            )

            ->add('agent', EntityType::class, [
                'mapped' => false,
                'class' => Agents::class,
                'choice_label' => function ($agent) {
                    return $agent->getLastname() . "(" . $agent->getNationality() . ")";
                }, 'label' => 'Nom de l\'agent',
                'multiple' => true,
                'expanded' => true
            ])

            ->add(
                'contact',
                EntityType::class,
                [
                    'mapped' => false, 'class' => Contacts::class,
                    'choice_label' => function ($contact) {
                        return $contact->getNameCode() . "(" . $contact->getNationality() . ")";
                    }, 'label' => 'Nom de code du Contact',
                    'multiple' => true, 'expanded' => true
                ]
            )

            ->add(
                'target',
                EntityType::class,
                [
                    'mapped' => false, 'class' => Targets::class, 'choice_label' => function ($target) {
                        return $target->getNameCode() . "(" . $target->getNationality() . ")";
                    }, 'label' => 'Nom de code de la Cible',
                    'multiple' => true, 'expanded' => true
                ]
            )

            ->add(
                'hideout',
                EntityType::class,
                [
                    'mapped' => false, 'class' => Hideout::class, 'choice_label' => function ($hideout) {
                        return $hideout->getId() . "(" . $hideout->getCountry() . ")";
                    }, 'label' => 'Code Planque',
                    'multiple' => true, 'expanded' => true
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
