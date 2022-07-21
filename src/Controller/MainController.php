<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Repository\BudgetRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(BudgetRepository $budgetRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'budgets' => $budgetRepository->findAll(),
        ]);
    }

    #[Route('/budget/{id}', name: 'budget')]
    public function viewBudget(Budget $budget, CategoryRepository $categoryRepository): Response
    {
        $totalAmount = 0;
        $totalSpent  = 0;

        $categories = $categoryRepository->findBy(['budget' => $budget]);

        foreach ($categories as $category) {

            $totalAmount += $category->getAmount();

            $category->amounts = 0;

            $products = $category->getProducts();

            if (!$products) {
                continue;
            }

            foreach ($products as $product) {
                $category->amounts += $product->getAmount();
            }

            $totalSpent += $category->amounts;
        }

        return $this->render('main/budget.html.twig', [
            'budget'      => $budget,
            'categories'  => $categoryRepository->findBy(['budget' => $budget]),
            'totalAmount' => $totalAmount,
            'totalSpent'  => $totalSpent,
        ]);
    }
}
