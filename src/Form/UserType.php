<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('prenom')
            ->add('nom')
            ->add('telephone')
            ->add('aPropos')
            ->add('instagram')
            ->add('roles', ChoiceType::class, [
                'multiple' => true, // Si vous souhaitez permettre plusieurs rôles
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Artiste' => 'ROLE_PEINTRE',
                ],
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
