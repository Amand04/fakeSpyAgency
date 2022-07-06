<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\Skills;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SkillFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class)

            ->add('agent', EntityType::class, ['mapped' => false, 'class' => Agents::class, 'choice_label' => function ($agent) {
                return $agent->getName();
            }, 'label' => 'Agent correspondant', 'multiple' => true, 'expanded' => true]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Skills::class,
        ]);
    }
}
