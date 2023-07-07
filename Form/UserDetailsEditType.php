<?php

namespace App\Form;

use App\Entity\UserDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDetailsEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'required' => false,
                'label'=>false
            ])
            ->add('surname', TextType::class,[
                'required' => false,
                'label'=>false
            ])
            ->add('description', TextareaType::class,[
                'required' => false,
                'label'=>false
            ])
            ->add('emailNotification',CheckBoxType::class,[
                'required' => false,
                'label'=>false
            ])
            ->add('pushNotification',CheckBoxType::class,[
                'required' => false,
                'label'=>false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserDetails::class,
        ]);
    }
}
