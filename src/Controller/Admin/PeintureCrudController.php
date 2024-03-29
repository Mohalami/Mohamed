<?php

namespace App\Controller\Admin;

use App\Entity\Peinture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PeintureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Peinture::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
           TextField::new('nom'),
           TextareaField::new('description'),
           DateField::new('dateRealisation'),
           NumberField::new('largeur')->hideOnIndex(),
           NumberField::new('hauteur')->hideOnIndex(),
           NumberField::new('prix')->hideOnIndex(),
           BooleanField::new('enVente'),
           BooleanField::new('portfolio'),
           TextField::new('imageFile')->setFormType(VichImageType::class)->onlyWhenCreating(),
           ImageField::new('file')->setBasePath('/uploads/peintures/')->onlyOnIndex(),
           SlugField::new('slug')->setTargetFieldName('nom')->hideOnIndex(),
           AssociationField::new('categorie'),
        ];

        
        // Ajoutez le champ imageFile uniquement lors de la création
        if ($pageName === Crud::PAGE_NEW) {
                $fields[] = TextField::new('imageFile')
                    ->setFormType(VichImageType::class);
            }
            
            return $fields;
        }
        
        public function configureCrud(Crud $crud): Crud
        {
            return $crud
                ->setDefaultSort(['createdAt' => 'DESC']);
        }


    }
