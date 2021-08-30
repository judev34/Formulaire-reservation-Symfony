<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Field\VichImageField;
use App\Form\PieceJointeType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('nom'),
            SlugField::new('slug')
            ->setTargetFieldName('nom'),
            TextareaField::new('description'),
            CollectionField::new('piecejointes')
            ->SetEntryType(PieceJointeType::class)
            ->setFormTypeOption('by_reference', false)
            ->onlyOnForms(),
            CollectionField::new('pieceJointes')
            // ->setTemplatePath('article.html.twig')
            ->setTemplatePath('images.html.twig')
            ->onlyOnDetail()
            
        ];

        $image = ImageField::new('miniature')
        ->setFormType(VichImageType::class)
        ->setBasePath('uploads/images/miniatures')
        // indiquer la direction de lecture
        ->setUploadDir('public/uploads/images/miniatures')
        ->setTemplatePath('miniature.html.twig');
        // indique la direction de l'upload
        // ->setUploadedFileNamePattern('[randomhash].[extension]')
        // modifie le nom de facon aleatoire pour le fichier
        // ->setRequired(false);

        $imageFile = TextAreaField::new('miniatureFile')
        ->setFormType(VichImageType::class);
        // ->setBasePath('uploads/images/miniatures')
        // ->setUploadDir('public/uploads/images/miniatures');
        // // ->setUploadedFileNamePattern('[randomhash].[extension]');
        // // TextAreaField::new('miniatureFile')
        // // ->setFormType(VichImageType::class),

        if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $image;
        } else {
            $fields[] = $imageFile;
        }
        return $fields;

    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(CRUD::PAGE_INDEX, 'detail');
    }

}
