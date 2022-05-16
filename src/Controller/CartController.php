<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
        private $entityManager;


public function __construct(EntityManagerInterface $entityManager){
    $this->entityManager=$entityManager;

}


    /**
     * @Route("/mon-panier", name="cart")
     * @param Cart $cart
     */
    public function index(Cart $cart)
    {



        return $this->render('cart/index.html.twig',
            ['cart' => $cart->getFull()]
        );
    }

    /**
     * @param $id
     * * @Route("/cart/add/{id}", name="add_to_cart")
     * @param Cart $cart
     * @return Response
     */
    public function add($id, Cart $cart)
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @param $id
     * @Route("/cart/remove", name="remove_my_cart")
     * @param Cart $cart
     * @return Response
     */
    public function remove( Cart $cart)
    {
        $cart->remove();
        return $this->redirectToRoute('products');
    }

    /**
     * @param $id
     * @Route("/cart/delete/{id}", name="delete_to_cart")
     * @param Cart $cart
     * @return Response
     */
    public function delete( Cart $cart , $id)
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }
    /**
     * @param $id
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     * @param Cart $cart
     * @return Response
     */
    public function decrease( Cart $cart , $id)
    {
        $cart->decrease($id);
        return $this->redirectToRoute('cart');
    }
}
