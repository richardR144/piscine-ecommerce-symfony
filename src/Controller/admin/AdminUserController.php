<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/admin/create-admin', name: 'admin-create-admin')]
class AdminUserController extends AbstractController {
    public function displayCreateUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager) {

        if($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $user = new User();

            $passwordHashed = $userPasswordHasher->hashPassword($user, $password);

            //Méthode 1
            //$user->setPassword($passwordHashed);
            //$user->setEmail($email);
            //$user->setRoles(['ROLE_ADMIN']);

            //Méthode 2
            $user->createAdmin($email, $passwordHashed);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Admin créé');
            
        }
            return $this->render('admin/user/create-user.html.twig');
    }
}

    //11 David: Créez un nouveau controleur en admin "AdminUserController", avec une route "admin-create-admin"
    //La route affiche un formulaire en twig contenant un champs email et un champs password
    //Au submit, récupérez les données du formulaire et, grâce à une instance de la classe "UserPasswordHasherInterface" de Symfony, créez un hash pour le mot de passe récupéré
    //Affichez l'email envoyé + le mot de passe hashé avec des dumps

    //12 David: Sur le controleur de création d'admin, stockez l'email, le mot de passe hashé et le role dans l'entité User et enregistrez là en BDD
