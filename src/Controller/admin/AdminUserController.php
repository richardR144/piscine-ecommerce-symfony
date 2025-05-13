<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;




class AdminUserController extends AbstractController {
    #[Route('/admin/create-admin', name: 'admin-create-admin')]
    public function displayCreateUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) {

        if($request->isMethod('POST')) {                    // je vérifie que les données sont envoyés en POST
            $email = $request->request->get('email');       // je récupère l'email et le mot de passe envoyée par le formulaire
            $password = $request->request->get('password');

            $user = new User();  //je créais une nouvelle instance de l'entité user

            $passwordHashed = $userPasswordHasher->hashPassword($user, $password);
            //Hash le mot de passe avec le service de Symfony

            //Méthode 1
            //$user->setPassword($passwordHashed);
            //$user->setEmail($email);
            //$user->setRoles(['ROLE_ADMIN']);

            //Méthode 2
            $user->createAdmin($email, $passwordHashed);  
            // Utilise une méthode personnalisée pour initialiser l'admin

            try {   //exo 13, 14
				$entityManager->persist($user);
				$entityManager->flush();
				$this->addFlash('success','Admin créé');
				return $this->redirectToRoute('admin-list-admins');

			} catch(Exception $exception) {

				$this->addFlash('error', 'Impossible de créer l\'admin');

				// si l'erreur vient de la clé d'unicité, je créé un message flash ciblé
				if ($exception->getCode() === '1062') {
					$this->addFlash('error',  'Email déjà pris.');
				}
            
        }
            //Affiche le formulaire de création
            return $this->render('admin/user/create-user.html.twig');
        }
    }

            #[Route(path: '/admin/list-admins', name: 'admin-list-admins')]
            public function displayListAdmins(UserRepository $userRepository) {

                $users = $userRepository->findAll();

                return $this->render('/admin/user/list-users.html.twig', [
                    'users' => $users
        ]);
    }
}



    //11 David: Créez un nouveau controleur en admin "AdminUserController", avec une route "admin-create-admin"
    //La route affiche un formulaire en twig contenant un champs email et un champs password
    //Au submit, récupérez les données du formulaire et, grâce à une instance de la classe "UserPasswordHasherInterface" de Symfony, créez un hash pour le mot de passe récupéré
    //Affichez l'email envoyé + le mot de passe hashé avec des dumps

    //12 David: Sur le controleur de création d'admin, stockez l'email, le mot de passe hashé et le role dans l'entité User et enregistrez là en BDD

    // 13 David: Dans le controleur de création d'admin, rajoutez un try catch 
    //autour du persist de l'entité $user. A la fin du try rajoutez un message flash de succès. 
    //A la fin du catch, rajoutez un message flash d'erreur. Puis si, le code de l'erreur 
    //est 1062 (erreur de clé d'unicité), rajoutez un autre message flash erreur pour dire 
    //que dire que l'email est déjà pris}

    //14 David: Créez une page en admin pour lister tous les users créés
    //Ajoutez cette page dans les liens du menu de l'admin
    //Modifiez la création de l'utilisateur : quand l'utilisateur est créé, redirigez vers la liste des utilisateurs