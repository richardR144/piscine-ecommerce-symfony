<?php

namespace App\Controller\guest;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRepository;


class ProductController extends AbstractController
{
    #[Route('/products', name: 'products-list')]
        public function displayListProduct(CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findBy(['isPublished' => true]);
        $category = $categoryRepository->findAll();
        
        return $this->render('guest/products-list.html.twig', [
            'products' => $product, 'categories' => $category
        ]);
    }

    #[Route('/products/{id}', name: 'show-product')]
        public function showCategory($id, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $products = $productRepository->find($id);
        $category = $categoryRepository->findAll();
        return $this->render('guest/show-product.html.twig', [
            'product' => $products, 'categories' => $category
        ]);
    }
}