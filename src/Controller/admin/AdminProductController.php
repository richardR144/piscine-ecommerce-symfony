<?php


namespace App\Controller\admin;

use Exeption;
use App\Entity\Product;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\admin\Exception;



class AdminProductController extends AbstractController {

    //je créais une route pour afficher la page de création de produit url(/admin/create-product)
	#[Route('/admin/create-product', name: 'admin-create-product')]
    //je fais appel au repository de la catégorie pour récupérer toutes les catégories et j'instancie l'entité Product
	public function displayCreateProduct(CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $entityManager) {

        //je vérifie si la création de produit est bien de la méthode ('POST')
			if ($request->isMethod('POST')) {
        	//je récupère les données du formulaire
			$title = $request->request->get('title');
			$description = $request->request->get('description');
			$price = $request->request->get('price');
            $categoryId = $request->request->get('category-id'); //je récupère l'id de la catégorie par le nom du champ
			//si le champ is-published est coché, je le met à true sinon false
			

			if ($request->request->get('is-published') === 'on') {
				$isPublished = true;
			} else {
				$isPublished = false;
			}

			//je fais appel au repository de la catégorie pour récupérer la catégorie par son id
            $category = $categoryRepository->find($categoryId);

			try {
				//je fais appel à l'entité Product pour créer un nouveau produit
				$product = new Product($title, $description, $price, $isPublished, $categoryId);
				$entityManager->persist($product);
            	$entityManager->flush();

			} catch (\Exception $exception) {
				$this->addFlash('error', $exception->getMessage());
			}
			
            //je fais appel à l'entité Product pour créer un nouveau produit
            
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

/** seconde méthode pour créer un produit avec le formulaire Symfony
	 * #[Route('/admin/create-product-form-sf', name: 'admin-create-product-form-sf')]
	*public function displayCreateProductFormSf(Request $request, EntityManagerInterface $entityManager) {
	*
	*	$product = new Product();
	*
	*		$productForm = $this->createForm(ProductForm::class, $product);
	*	$productForm->handleRequest($request);
	*
	*	if ($productForm->isSubmitted()) {
	*		$product->setCreatedAt(new \DateTime());
	*		$product->setUpdatedAt(new \DateTime());
	*
	*		$entityManager->persist($product);
	*		$entityManager->flush();
	*	}
	*	
	*	return $this->render('admin/product/create-product-form-sf.html.twig', [
	*		'productForm' => $productForm->createView()
	*	]);
	*}
	**/

    /*1 David : Via phpmyadmin, créez quelques catégories, puis créez quelques articles
Créez dans le dossier guest un controleur CategoryController
Dans ce controleur, créez une page qui affiche toutes les catégories (seulement le titre)
Créez une page qui affiche une catégorie via son id (titre, description, date de création et date de modif)

Créez dans le dossier guest un controleur ProductController
Dans ce controleur, créez une page qui affiche tous les produits publiés (isPublished à true) (seulement le titre)
Créez une page qui affiche un produit via son id (titre, description, prix, date de création et date de modif)

2 David: dans templates :
Déplacez le fichier base (ou créez le) dans le dossier guest
Créez deux sous dossiers dans le dossier guest : product et category et placez vos fichiers de liste et de détails dedans
Modifiez vos controleurs pour mettre les bons chemins vers les fichiers twig

3 David: Créez un AdminProductController dans le dossier admin
A l'intérieur créez la page permettant de créer un product :
-- soit à la main (en créant le formulaire html puis en récupérant les données)
-- soit avec les forms de symfony (make:form etc)

Si vous faites à la main : créez le formulaire, récupérez les données et affichez les dans des dump en première étape 
(on fera le tp après pour sauvegarder les données). 
Attention à la gestion du isPublished (la checckbox renvoie "on" ou "off"

4 David: après avoir récupéré les données du formulaire de création de product, stockez les dans une instance de 
l'entité Product et enregistrez le product en BDD

5 David: Créez un fichier base.html.twig pour la partie admin
Faites un extend du base dans votre twig de create-product
Dans le base, ajoutez sous le header la boucle qui permet d'afficher les messages flashs

Modifiez le constructeur de l'entité Product pour vérifier si le titre fait moins de 3 caractères. Si c'est le cas, envoyez une exeception avec un message
Dans le controleur, utilisez try catch autour de la création du produit (new Product) pour récupérez l'erreur et l'afficher avec un message flash

*/ 