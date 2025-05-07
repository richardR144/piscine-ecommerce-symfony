<?php

namespace App\Controller\guest;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;


class CategoryController extends AbstractController {

    #[Route('/categories', name: 'category')]
    public function displayCategory(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll('title'); 

        return $this->render('guest/category.html.twig', [
            'categories' => $categories
        ]);
    }
}