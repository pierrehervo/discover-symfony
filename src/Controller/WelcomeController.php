<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function hello(Request $request)
    {
        $name = 'Matthieu';

        // $request->get('a') équivaut à $_GET['a']
        dump($request);

        // On fait un rendu de la vue Twig qui est située
        // dans le dossier templates/
        // Le controleur passe la variable name à la vue grâce au second paramètre de render qui est un tableau
        return $this->render('welcome/hello.html.twig', [
            'name' => $name,
        ]);
    }
}
