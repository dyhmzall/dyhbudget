<?php

namespace App\Controller\Admin;

use App\Entity\Budget;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BudgetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Budget::class;
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
