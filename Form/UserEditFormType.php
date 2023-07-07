<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('roles',ChoiceType::class, [
                'multiple' => true,
                'required' => false,
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Moderator' => 'ROLE_MODERATOR',
                    'Admin' => 'ROLE_ADMIN'
                ],

            ])
            ->add('email',EmailType::class,[
                'required' => false,
                'label'=>false

            ])
            ->add('isVerified',CheckboxType::class,[
                'required' => false,
                'label'=>false
            ])
            ->add('activate',CheckboxType::class,[
                'required' => false,
                'label'=>false
            ])
            ->add('banned',CheckboxType::class,[
                'required' => false,
                'label'=>false
            ])
            ->add('UserDetails',UserDetailsEditType::class,[
                'required' => false,
                'label'=>false
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
