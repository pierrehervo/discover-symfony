<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function hello()
    {
        $name = 'Matthieu';

        return new Response('Salut les gens et '.$name);
    }
}
