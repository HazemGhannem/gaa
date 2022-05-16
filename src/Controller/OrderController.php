<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;

    }



    /**
     * @Route("/commande", name="order")
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    public function index(Cart $cart): Response
    {
        if(!$this->getUser()->getAdresses()->getValues()){
            return $this->redirectToRoute('ajouter-adresse');
        }


        $form = $this->createForm(OrderType::class ,null,
            ['user' => $this->getUser() ]
        );



        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }
    /**
     * @Route("/commande/recap", name="order_recap" , methods={"POST"})
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    public function add(Cart $cart ,Request $request): Response
    {



        $form = $this->createForm(OrderType::class ,null,
            ['user' => $this->getUser() ]
        );
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('adresses')->getData();
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname().'<br/>'.$delivery->getPhone().'<br/>'.$delivery->getAdress().' '.$delivery->getVille().' '.$delivery->getPostal();


            $date = new \DateTime();
            $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrix());
            $order->setDelivery($delivery_content);
            $order->setState(0);
            $this->entityManager->persist($order);



            foreach ($cart->getFull() as $produit){
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($produit['produit']->getName());
                $orderDetails->setQuantity($produit['quantity']);
                $orderDetails->setPrice($produit['produit']->getPrix());
                $orderDetails->setTotal($produit['produit']->getPrix() * $produit['quantity']);
                $this->entityManager->persist($orderDetails);



            }
            $this->entityManager->flush();




            return $this->render('order/add.html.twig',[

                'cart' => $cart->getFull() ,
                'carrier' => $carriers ,
                'delivery' => $delivery_content,
                'reference' => $order->getReference()
            ]);



        }
        return $this->redirectToRoute('cart');



    }

    /**
     * @Route("/admin/order", name="afficheOrder" )
     * @param Request $request
     * @param OrderRepository $orderRepository
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function affiche(Request $request,OrderRepository $orderRepository, PaginatorInterface $paginator){
        $order = $orderRepository->findAll();

        $order = $paginator->paginate(
            $order,
            $request->query->getInt('page',1),
            10

        );


        return $this->render('admin/order/affiche.html.twig',
            ['order' => $order]);
    }



}
