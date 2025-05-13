<?php


namespace App\Controller\guest;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController {

    //je créais une route pour afficher la liste des produits
    //et une autre pour afficher les détails d'un produit
	#[Route('/list-products', name:'list-products', methods: ['GET'])]
	public function displayListProducts(ProductRepository $productRepository): Response {
		// la méthode findBy() permet de récupérer les produits publiés
		$productsPublished = $productRepository->findBy(['isPublished' => true]);
        //je retourne la liste des produits publiés en utilisant la méthode render()
        //et en lui passant le nom du template et les données à afficher
        //le template est situé dans le dossier templates/guest/product/list-products.html.twig
		return $this->render('guest/product/list-products.html.twig', [
			'products' => $productsPublished
		]);
	}

	#[Route('/details-product/{id}', name:'details-product', methods: ['GET'])]
	public function displayDetailsProduct(ProductRepository $productRepository, int $id): Response {
		// la méthode find() permet de récupérer un produit par son id
        //je récupère le produit correspondant à l'id passé en paramètre
		$product = $productRepository->find($id);

		if(!$product) {
			return $this->redirectToRoute("404");
		}

		return $this->render('guest/product/details-product.html.twig', [
			'product' => $product
		]);

	}


	// Exo 19 Route pour afficher la page de résultats de recherche
	//Un controller Symfony doit toujours retourner une Resdponse, car c'est ce qui sera envoyé au client(navigateur)
	#[Route(path: '/resultats-recherche', name:'product-search-results', methods: ['GET'])]
	public function displayResultsSearchProducts(Request $request, ProductRepository $productRepository): Response {
	// Récupère la valeur du champ 'search' envoyé dans l'URL (GET)
		$search = $request->query->get('search');

		$productsFound = $productRepository->findByTitleContain($search); 
		//dd($productsFound);

		//20 David: faire une requête select dans la table product avec le critère de recherche dans ProductRepository

		return $this->render('guest/product/search-results.html.twig', [
			'products' => $productsFound,
			'search' => $search
		]);
		//au dessus, je retournes une Response et c'est obligatoire pour que Symfony puisse afficher la page de résultats 
		//de recherche à l'utilisateur
	}

}