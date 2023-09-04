<?php

namespace App\Form;

use App\Entity\Peinture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Form\Extension\Core\Type\TextType; 

class PeintureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('largeur')
            ->add('hauteur')
            ->add('enVente')
            ->add('prix')
            ->add('dateRealisation')
            // ->add('createdAt')
            ->add('description')
            ->add('portfolio')
            // ->add('slug')
            ->add('imageFile', FileType::class, [ // Utilisez 'imageFile' au lieu de 'file'
                'label' => 'Image', // Personnalisez le label selon vos besoins
                'required' => false, // Selon vos besoins
            ])
            // ->add('user')
            // ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Peinture::class,
        ]);
    }
}
