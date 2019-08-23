<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $products = [];

    public function __construct()
    {
        // On initialise un tableau avec des produits
        // L'attribut $products est accessible sur toutes les routes...
        $this->products = [
            ['name' => 'iPhone X', 'slug' => 'iphone-x', 'description' => 'Un iPhone de 2017', 'price' => 999],
            ['name' => 'iPhone XR', 'slug' => 'iphone-xr', 'description' => 'Un iPhone de 2018', 'price' => 1099],
            ['name' => 'iPhone XS', 'slug' => 'iphone-xs', 'description' => 'Un iPhone de 2018', 'price' => 1199]
        ];
    }

    /**
     * @Route("/product/create")
     */
    public function create(Request $request)
    {
        // On crée un produit "vierge"
        $product = new Product();
        dump($product);

        // Créer un formulaire dans le contrôleur
        $form = $this->createForm(ProductType::class, $product);

        // Traitement du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données du formulaire
            dump($form->getData());
            dump($product);
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/random")
     */
    public function random()
    {
        // On récupére une clé aléatoire du tableau
        $key = array_rand($this->products);
        // On récupére le product "random"
        $product = $this->products[$key];

        dump($product);

        return $this->render('product/random.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/product/{page}", requirements={"page"="\d+"})
     */
    public function list($page = 1)
    {
        // ['A', 'B', 'C', 'D', 'E', 'F', 'G']
        $products = $this->products;
        // ['E', 'F']
        $products = array_slice($products, ($page - 1) * 2, 2);
        // Calculer le nombre de page maximal
        // Dans l'exemple 3,5 arrondi à 4
        $maxPages = ceil(count($this->products) / 2);

        // Si la page courante est supérieure au nombre maximum de pages
        // on renvoie une 404
        if ($page > $maxPages) {
            throw $this->createNotFoundException();
        }

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'current_page' => $page,
            'max_pages' => $maxPages
        ]);
    }

    /**
     * @Route("/product/{slug}")
     */
    public function show($slug)
    {
        // On va parcourir tous les produits
        foreach ($this->products as $product) {
            // Si le slug du produit correspond à celui de l'URL
            if ($product['slug'] === $slug) {
                // Si un produit existe avec le slug, on retourne le template et on arrête le code
                return $this->render('product/random.html.twig', [
                    'product' => $product,
                ]);
            }
        }

        // On s'assure de parcourir tout le tableau et seulement on affiche la 404
        throw $this->createNotFoundException();
    }

    /**
     * @Route("/product.json")
     */
    public function api()
    {
        // On renvoie le tableau des produits sous forme de JSON
        return $this->json($this->products);
    }

    /**
     * @Route("/product/order/{slug}")
     */
    public function order($slug)
    {
        $alphabet = ['A', 'B', 'C'];
        // $newAlphabet = ['A'];
        $newAlphabet = array_filter($alphabet, function ($lettre) { return $lettre === 'A'; });

        // Chercher le produit concerné dans notre tableau
        // Le terme "use" du callback permet d'utiliser une variable définie en dehors de celui-ci
        $product = array_filter($this->products, function ($product) use ($slug) {
            // Cette fonction est appelée sur chaque élément du tableau
            // On renvoie true si on veut garder l'élément dans le filtre qu'on applique
            return $product['slug'] === $slug;
        });
        // Réinitialise les index du tableau filtré
        $product = array_values($product);
        // On ne prend qu'un seul produit
        $product = $product[0];

        // Pour créer le message flash en session (il est juste stocké)
        $this->addFlash('success', 'Nous avons bien pris en compte votre commande de '.$product['price'].' €');

        // Après la commande, on redirige vers la liste des produits
        return $this->redirectToRoute('app_product_list');
    }
}
