<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(): Response
    {
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }

    #[Route('/signup', name: 'app_signup')]
    public function signup(Request $request, UserRepository $userRepository,EntityManagerInterface $entityManager): Response
    {
        $email = $request->request->get('email');
        $nom= $request->request->get('nom');
        $prenom= $request->request->get('prenom');
        $password = $request->request->get('password');
        $confirmPassword = $request->request->get('confirm_password');
        $birthday = $request->request->get('birthday');


        // Vérification si les mots de passe correspondent
        if ($password !== $confirmPassword) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas');
            return $this->redirectToRoute('app_signup');
        }

        $user = new User();
        $user->setEmail($email);
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setPassword($password);  // Ici on ne fait pas de hashage, c'est juste pour simplification
        $birthdayDate = \DateTime::createFromFormat('Y-m-d', $birthday); // Convertir la chaîne en DateTime
        $user->setBirthday($birthdayDate);
        if (!$birthdayDate) {
            $this->addFlash('error', 'Format de date invalide');
            return $this->redirectToRoute('app_register');
        }
        $entityManager->persist($user);
        $entityManager->flush();
        // Message de succès
        $this->addFlash('success', 'Compte créé avec succès !');

        // Redirection vers la page de connexion
        return $this->redirectToRoute('app_register');
    }
}
