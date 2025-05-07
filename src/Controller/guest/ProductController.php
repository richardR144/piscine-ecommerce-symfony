<?php

namespace App\Controller\guest;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;


class ProductController extends AbstractController
{
    #[Route('/products', name: 'product')]
    public function displayProduct(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll('title');
        
        return $this->render('guest/product.html.twig', [
            'products' => $products
        ]);
    }
}