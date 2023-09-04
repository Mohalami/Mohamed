<?php

namespace App\Controller\Admin;

use App\Entity\Blogpost;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlogpostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blogpost::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),

            // pour rendre le champ invisible dans le form on rejoute ->hideOnForm
            TextField::new('slug')->hideOnForm(),
            TextareaField::new('contenu'),
            DateField::new('createdAt')->hideOnForm(),
        ];
    }

    // Pour configurer le crud
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        // Pour classer de facon decroissaante
            ->setDefaultSort(['createdAt' => 'DESC']);
    }
    
}
