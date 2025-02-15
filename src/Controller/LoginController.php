<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



final class LoginController extends AbstractController
{


    #[Route('/', name: 'app_login')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'erreur' => ''
        ]);
    }

    #[Route('/login', name: 'app_login-check',methods: ['POST'])]
    public function login(Request $request,UserRepository $userRepository):Response
    {
        $email = $request->request->get('_username');
        $password = $request->request->get('_password');
        $user= $userRepository->findOneBy(['email'=>$email,'password'=>$password]);

        if(!$user){
            $this->addFlash('error', 'Identifiants incorrects');
            return $this->redirectToRoute('app_login');
        }
        else{
            $fete=false;
            $currentDate = new \DateTime();
            if($user->getBirthday()->format('d-m-Y')== $currentDate->format('d-m-Y')){
                $fete=true;
            }
            return $this->redirectToRoute('app_home',['nom'=>$user->getNom(),'prenom'=>$user->getPrenom(),'birthday'=>$user->getBirthday(),'fete'=>$fete]);
        }

    }
}
