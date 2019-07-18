<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use App\Repository\ProductRepository;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    function cart(ProductRepository $repo)
    {
        $session = new Session();
        $cart = $session->get('session_cart');
        $products = array();

        $total_ht = 0;

        // Calcul du total HT, mnt TVA et total TTC
        // On ne doit pas laisser la vue faire le calcul
        if ($cart)
            foreach ($cart as $produit_id => $qty) {
                $prd = $repo->find($produit_id);
                $products[] = $prd;
                $total_ht += $prd->getPrice() * explode("#", $qty)[0];
            }

        $mnt_tva = $total_ht * 10 / 100;
        $total_ttc = $total_ht + $mnt_tva;

        return $this->render(
            "cart/cart.html.twig",
            [
                'products' => $products,
                'cart' => $cart,
                'total_ht' => $total_ht,
                'mnt_tva' => $mnt_tva,
                'total_ttc' => $total_ttc
            ]
        );
    }


    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    function addToCart(Product $produit, Request $request)
    {
        $session = new Session();
        @$cart = $session->get('session_cart');
        $data = 0;
        if ($request->request->count() > 0) {
            $data = $request->request->get('quantite') . '#' . $request->request->get('color') . '#' . $request->request->get('description');
        }


        @$cart[$produit->getId()] = $data;
        $session->set('session_cart', $cart);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove/{id}", name="remove_from_cart")
     */
    function removeFromCart($id)
    {
        $session = new Session();
        $cart = $session->get('session_cart');
        unset($cart[$id]); // Remove item from row
        $session->set('session_cart', $cart);

        // Retrouner au panier
        return $this->redirectToRoute('cart');
    }


    /**
     * @Route("/cleancart" , name="clear_cart")
     */
    public function cleancart()
    {
        $session = new Session();
        $session->clear();

        return $this->redirectToRoute('cart');
    }



    public function nbproduit()
    {
        // récuprer le panier depuis la session et calculer le nb des prd
        $session = new Session();
        $cart = $session->get('session_cart');
        $n = empty($cart) ? 0 : count($cart);
        // count($cart)
        return $this->render('cart/panier.html.twig', [
            'n' => $n
        ]);
    }

    /**
     * @Route("/cart/add/one/{id}", name="add_one_to_cart")
     */
    function addOneToCart(Product $prd)
    {
        $session = new Session();
        @$cart = $session->get('session_cart');

        $qty = explode("#", $cart[$prd->getId()])[0] + 1;
        $data = $qty . '#' . explode("#", $cart[$prd->getId()])[1] . '#' . explode("#", $cart[$prd->getId()])[2];

        @$cart[$prd->getId()] = $data;
        $session->set('session_cart', $cart);

        return $this->redirectToRoute('cart');
    }


    /**
     * @Route("/cart/remove/one/{id}", name="remove_one_to_cart")
     */
    function removeOneToCart(Product $prd)
    {
        $session = new Session();
        @$cart = $session->get('session_cart');


        $qty = explode("#", $cart[$prd->getId()])[0] - 1;
        $data = $qty . '#' . explode("#", $cart[$prd->getId()])[1] . '#' . explode("#", $cart[$prd->getId()])[2];


        @$cart[$prd->getId()] = $data;
        $session->set('session_cart', $cart);

        return $this->redirectToRoute('cart');
    }
}
