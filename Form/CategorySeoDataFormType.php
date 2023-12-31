<?php

namespace App\Form;

use App\Entity\CategorySeoData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorySeoDataFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('metaTitle', TextType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('metaDescription', TextareaType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('metaKeywords', TextType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('seoDescription', TextareaType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'id' => 'tinymce-mytextarea',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategorySeoData::class,
        ]);
    }
}
