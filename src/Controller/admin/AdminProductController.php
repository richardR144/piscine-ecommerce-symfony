<?php


namespace App\Controller\admin;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class AdminProductController extends AbstractController {

    //je créais une route pour afficher la page de création de produit url(/admin/create-product)
	#[Route('/admin/create-product', name: 'admin-create-product')]
    //je fais appel au repository de la catégorie pour récupérer toutes les catégories
	public function displayCreateProduct(CategoryRepository $categoryRepository, Request $request) {
        //je créais une méthode pour afficher la page de création de produit ('POST')
		if ($request->isMethod('POST')) {
        //je récupère les données du formulaire
			$title = $request->request->get('title');
			$description = $request->request->get('description');
			$price = $request->request->get('price');
			$categoryId = $request->request->get('category-id');
			//si le champ is-published est coché, je le met à true sinon false
			if ($request->request->get('is-published') === 'on') {
				$isPublished = true;
			} else {
				$isPublished = false;
			}
		}

        //je récupère la liste des catégories
        //je fais appel au repository de la catégorie pour récupérer toutes les catégories

		$categories = $categoryRepository->findAll();

        //je fais un dump pour voir si je récupère bien les catégories
        //dump($categories);
        //je retourne la vue create-product.html.twig et je fais un render pour afficher la page
		return $this->render('admin/product/create-product.html.twig', [
            //je passe la liste des catégories à la vue
			'categories' => $categories
		]);
	}
}

