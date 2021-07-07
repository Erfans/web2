<?php

namespace App\Controller\Admin;

use App\Entity\BookStore;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookStoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BookStore::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
