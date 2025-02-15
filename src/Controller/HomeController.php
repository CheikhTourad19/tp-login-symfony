<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(Request $request): Response
    {
        $nom = $request->query->get('nom');
        $prenom = $request->query->get('prenom');
        $birthday = $request->query->get('birthday');
        $fete = $request->query->get('fete', false);

        return $this->render('home/index.html.twig', [
            'nom' => $nom,
            'prenom' => $prenom,
            'birthday' => $birthday,
            'fete' => $fete
        ]);
    }

}
