<?php

namespace App\Controller;

use App\Entity\Carrier;
use App\Entity\Product;
use App\Form\CarrierType;
use App\Form\ProductType;
use App\Repository\CarrierRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarrierController extends AbstractController
{


    /**
     * @param CarrierRepository $carrierRepository
     * @return Response
     * @Route ("admin/transporteur/affiche", name="afficheT")
     */
    public function Affiche(CarrierRepository $carrierRepository)
    {
        $carrier = $carrierRepository->findAll();
        return $this->render('admin/carrier/index.html.twig',
            ['carrier' => $carrier]);
    }

    /**
     * @param $id
     * @param CarrierRepository $carrierRepository
     * @return RedirectResponse
     * @Route ("admin/transporteur/delete/{id}", name="deleteT")
     */

    public function delete($id,CarrierRepository $carrierRepository){
        $carrier = $carrierRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($carrier);
        $em->flush();
        return $this->redirectToRoute("afficheT");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("admin/transporteur/ajouter", name="ajoutT")
     */
    public function Add(Request $request){
        $carrier = new Carrier();
        $form=$this->createForm(CarrierType::class,$carrier);
        $form->add('ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($carrier);
            $em->flush();
            return $this->redirectToRoute("afficheT");
        }
        return $this->render('admin/carrier/ajouter.html.twig',
            ['form' => $form->createView()]);
    }

    /**

     * @param ProductRepository $productRepository
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("admin/transporteur/update/{id}", name="updateT")
     */
    public function Update(CarrierRepository $carrierRepository, $id, Request $request){

        $carrier = $carrierRepository->find($id);
        $form=$this->createForm(CarrierType::class,$carrier);
        $form->add('update',SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheT');
        }
        return $this->render('admin/carrier/modifier.html.twig',
            ['form' => $form->createView()]
        );


    }

}
