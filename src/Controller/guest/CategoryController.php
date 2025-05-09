<?php


namespace App\Controller\guest;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController {

    //je créais une route pour afficher la liste des catégories
    //et une autre pour afficher les détails d'une catégorie
	#[Route('/list-categories', name:'list-categories')]
	public function displayListCategories(CategoryRepository $categoryRepository) {
		
		$categories = $categoryRepository->findAll();  // la méthode findAll() permet de récupérer toutes les catégories
        
		return $this->render('guest/category/list-categories.html.twig', [
			'categories' => $categories
		]);
	}

	#[Route('/details-category/{id}', name:'details-category')]
	public function displayDetailsCategory(CategoryRepository $categoryRepository, $id) {
		
		$category = $categoryRepository->find($id);

		return $this->render('guest/category/details-category.html.twig', [
			'category' => $category
		]);

	}

}