<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionCreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id', HiddenType::class, [
                'label' => false,
            ])
            ->add('title', TextType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('content', TextAreaType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('category', EntityType::class, [
                'required' => true,
                'label' => false,
                'class' => Categories::class,
                'choice_label' => 'name',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'id' => null,
        ]);
    }
}
