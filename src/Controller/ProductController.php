<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public $products = [];

    
   public function __construct()
   {
       //On initialise un tableau avec des produits 
       //L'attribut $products est accessible sur toutes les routes...
        $this->products = [
        ['name'=>'iphone 8','slug'=>'iphone-8','description'=>'portable de 2017','price'=>'990'],
        ['name'=>'iphone 9','slug'=>'iphone-9','description'=>'portable de 2018','price'=> '1000'],
        ['name'=>'iphone X','slug'=>'iphone-x','description'=>'portable de 2019','price'=>'1100']
        
       ];
   }

   /**
     * @Route("/product/random")
     */
    public function random()
    {
        //On ércupere une clé aléatoire du tableau
        $key = array_rand($this->products);
        //On récupére le product "random"
        $product = $this->products[$key];

        dump($product);

        return $this->render('product/random.html.twig', ['product'=>$product]);
    }

    /**
     * @Route("/product/{page}", requirements={"page"="\d+"})
     */
    public function array($page = 1)
    {
       $products = $this->products;
       $products = array_slice($products, ($page -1)*2, 2);//array_slice pour la pagination. La j'ai deux pages, qui affichent deux produits par pages
       $maxPages = ceil(count($this->products) /2); 
       //Si la page courante est sup au nombres max de pages, on met une 404
       if ($page > $maxPages){
           throw $this->createNotFoundException();
       }
       return $this->render('product/array.html.twig', [
            'products'=>$products,
            'current_page'=>$page,
            'max_pages'=> $maxPages
            ]);
    }

    /**
     * @Route("/product/{slug}")
     */
    public function product($slug)
    {
        //On va parcourir tous les produits
        foreach ($this->products as $product){
            //Si le slug du produit correspond à celui de l'URL
            if ($product['slug']===$slug){
                //Si un produit existe avec le slug, on retourne le template et on arrête le code
                return $this->render('product/random.html.twig', ['product' =>$product,]);
            }
        }
        //On s'assure de parcourir tout le tableau et seulement on affiche la 404
        throw $this->createNotFoundException();
    }

    /**
     * @Route("/product.json")
     */
    public function api()
    {
        //On renvoie le tableau des produits sous forme JSON
        return $this->json($this->products);
    }
}
