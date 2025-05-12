<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;


#[Route('/admin/create-admin', name: 'admin-create-admin')]
class createAdminController extends AbstractController {
    public function displayCreateAdmin(Request $request, UserPasswordHasherInterface $userPasswordHasher) {

        if($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $user = new User();

            $passwordHashed = $userPasswordHasher->hashPassword($user, $password);


        }
            return $this->render('admin/user/create-admin.html.twig');
    }
}

    //11 David: Créez un nouveau controleur en admin "AdminUserController", avec une route "admin-create-admin"
    //La route affiche un formulaire en twig contenant un champs email et un champs password
    //Au submit, récupérez les données du formulaire et, grâce à une instance de la classe "UserPasswordHasherInterface" de Symfony, créez un hash pour le mot de passe récupéré
    //Affichez l'email envoyé + le mot de passe hashé avec des dumps
