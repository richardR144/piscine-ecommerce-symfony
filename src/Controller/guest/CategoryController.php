<?php

namespace App\Controller\guest;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;


class CategoryController extends AbstractController {

    #[Route('/categories', name: 'category-list')]
    public function displayListCategory(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll(); 

        return $this->render('guest/categories-list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/categories/{id}', name: 'show-category')]
    public function showCategory($id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id); 

        return $this->render('guest/show-category.html.twig', [
            'category' => $category
        ]);
    }
}