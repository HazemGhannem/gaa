<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteOrderController extends AbstractController
{


    private $entityManager ;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/compte/mes-commandes", name="compte_order")
     */
    public function index(): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        return $this->render('compte/order.html.twig' ,
            ['orders' => $orders ]

        );
    }

    /**
     * @Route("/compte/mes-commandes/{reference}", name="compte_order_show")
     */
    public function show($reference)
    {
        $orders = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if(!$orders || $orders->getUser() != $this->getUser()){
            return $this->redirectToRoute('compte_order');
        }

        return $this->render('compte/order_show.html.twig' ,
            ['order' => $orders ]

        );
    }


}
