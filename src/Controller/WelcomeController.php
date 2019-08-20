<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class WelcomeController
{
    public function hello()
    {
        $name = 'Matthieu';

        return new Response('Salut les gens et '.$name);
    }
}
