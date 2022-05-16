<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adresse;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteAdressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;

    }




    /**
     * @Route("/compte/adress", name="compte_adress")
     */
    public function index(): Response
    {
        return $this->render('compte/adress.html.twig');
    }

    /**
     * @Route("/compte/ajouter-adresse", name="ajouter-adresse")
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    public function ajouter(Cart $cart , Request $request)
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdressType::class, $adresse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $adresse->setUser($this->getUser());
            $this->entityManager->persist($adresse);
            $this->entityManager->flush();
            if($cart->get()){
                return $this->redirectToRoute('order');
            }else{
                return  $this->redirectToRoute('compte_adress');
            }


        }


        return $this->render('compte/ajouterAdress.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-adresse/{id}", name="modifier-adresse")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function modifier( Request $request , $id): Response
    {
        $adresse = $this->entityManager->getRepository(Adresse::class)->findOneById($id);

        if(!$adresse || $adresse->getUser() != $this->getUser()){
            return $this->redirectToRoute('compte_adress');
        }

        $form = $this->createForm(AdressType::class, $adresse);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


            $this->entityManager->flush();
            return  $this->redirectToRoute('compte_adress');
        }


        return $this->render('compte/ajouterAdress.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/compte/supprimer-adresse/{id}", name="supprimer_adresse")
     * @param $id
     */
    public function supprimer($id)
    {
        $adresse = $this->entityManager->getRepository(Adresse::class)->findOneById($id);

        if($adresse && $adresse->getUser() == $this->getUser()){

            $this->entityManager->remove($adresse);

            $this->entityManager->flush();
        }

        return  $this->redirectToRoute('compte_adress');
    }

}
