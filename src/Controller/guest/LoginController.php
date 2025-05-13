<?php

namespace App\Controller\guest;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


// Contrôleur pour la gestion de l'authentification des utilisateurs invités (guest)
class LoginController extends AbstractController {
    #[Route('/login', name: "login")]           // Route pour afficher le formulaire de connexion
    public function displayLogin(AuthenticationUtils $authenticationUtils){
        // Récupère la dernière erreur de connexion (s'il y en a une)
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('guest/login.html.twig', [
                'error' => $error
        ]);        
    }
    //exo 10 + allez dans sécurité.yaml rajouter 
    //"default_target_path: admin-list-products" pour rediriger 
    //vers la liste des produits
    #[Route('/logout', name: "logout")]  
    public function logout(){ 
 // Cette méthode peut rester vide, elle sera interceptée par le firewall de Symfony
    }
}


//9 David: Dans la partie guest, créez un nouveau controller Login qui affiche un fichier twig avec à l'intérieur un formulaire de connexion
//Attention, le name du champs pour l'email doit être absolument "_username" et celui pour le mot de passe "_password"
//Allez voir dans sécurité yaml : form_login: à la ligne login_path: login,à la ligne check_path: login  "Attention à respecter les espaces"
                
//10 David:  Créez une méthode de controleur (avec une route) "logout" qui est vide
//Dans le security.yaml, rajoutez une clé logout dans le firewal avec le nom de la route qu'on vient de créer
//Dans le header de l'admin, créez un bouton de déconnexion qui envoie vers la route créée               