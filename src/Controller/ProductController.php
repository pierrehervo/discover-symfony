<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{page}", name="product_list", requirements={"page"="\d+"})
     */
    public function list($page)
    {
        return new Response('<body>Liste des produits page '.$page.'</body>');
    }

    /**
     * Si on se rend sur /product/toto ou /product/titi
     * Un slug, c'est transformer "iPhone X" en "iphone-x"
     *
     * @Route("/product/{slug}", name="product_show")
     */
    public function show($slug)
    {
        dump($slug);

        return $this->render('product/show.html.twig');
    }
}
