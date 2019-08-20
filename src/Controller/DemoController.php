<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
    // Générer des URLs
    /**
     * @Route("/urls")
     */
    public function genererUrls()
    {
        // La méthode generateUrl dans AbstractController permet de générer une URL à partir du nom d'une route
        $url = $this->generateUrl('hello');
        dump($url); // Affiche /hello
    }
    // Redirection
    /**
     * @Route("/redirect")
     */
    public function redirection()
    {
        // Redirection vers la page /hello
        return $this->redirectToRoute('hello');
    }

    // Afficher une 404
    /**
     * @Route("/notfound")
     */
    public function notfound()
    {
        // throw signifie "Lever une exception"
        throw $this->createNotFoundException();
    }
}
