<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{reference}", name="stripe_create_session")
     * @param EntityManagerInterface $entityManager
     * @param Cart $cart
     * @param $reference
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager,Cart $cart , $reference): Response
    {
        $product_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);
        if(!$order){
            new JsonResponse( ['error' => 'order']);

        }



        foreach ($order->getOrderDetails()->getValues() as $produit){
            $product_object = $entityManager->getRepository(Product::class)->findOneByName($produit->getProduct());

            $product_for_stripe[] =
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'unit_amount' => $produit->getPrice() * 100,
                        'product_data' => [
                            'name' => $produit->getProduct(),
                            'images' => [$YOUR_DOMAIN."/upload/img".$product_object->getImage()],
                        ],
                    ],
                    'quantity' => $produit->getQuantity(),


                ];


        }
        $product_for_stripe[] =
            [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $order->getCarrierPrice() * 100,
                    'product_data' => [
                        'name' => $order->getCarrierName(),
                        'images' => [$YOUR_DOMAIN],
                    ],
                ],
                'quantity' => 1,


            ];



        Stripe::setApiKey('sk_test_51IRyw6I64oE2lVFV80U8s6rPqNXpwaDSjow6Be2N7407fSgTZMlmW8gVsL76ltsa1XsWLKlKmiFhZtOxKA5DLkn200To37nvUm');



        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail()  ,
            'payment_method_types' => ['card'],
            'line_items' => [[
                $product_for_stripe
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN.'/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN.'/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);
        $order->setStripeSessionId($checkout_session->id);
        $entityManager->flush();
        return new JsonResponse( ['id' => $checkout_session->id]);

    }
}
