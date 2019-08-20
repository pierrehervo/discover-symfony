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

        // $request->get('a') équivaut à $_GET['a']
        return new Response('<body>Salut les gens et '.$name.'</body>');
    }
}
