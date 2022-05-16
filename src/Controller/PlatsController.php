<?php

namespace App\Controller;

use App\Entity\Plats;
use App\Form\PlatsType;
use Knp\Component\Pager\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Doctrine\Common\Collections\ArrayCollection;

class PlatsController extends AbstractController
{


    /**
     * @Route("/platsAdmin", name="platsAdmin")
     */
    public function platsAdmin(Request $request, PaginatorInterface $paginator): Response
    {
        $p=$this->getDoctrine()->getRepository(Plats::class);
        $plat=$p->findAll();
        if ($request->isMethod("POST"))
        {
            $nom_plat = $request->get("nom_plat");
            $plat=$p->findBy(array("nom"=>$nom_plat));

        }

            $plat =$paginator->paginate(
            $plat,
            $request->query->getInt('page',1),
            1

        );
        return $this->render('admin/plats/PlatsAdmin.html.twig', array('plats'=>$plat));
    }

    /**
     * @Route("/addPlat", name="addPlat")
     */
    public function ajouterPlat(Request $request){

        $plat = new Plats();
        $form = $this->createForm(PlatsType::class,$plat);


        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $file = $plat->getPhoto();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $plat->setPhoto($filename);

            $em =$this->getDoctrine()->getManager();
            $em->persist($plat);
            $em->flush();
            return $this->redirectToRoute('platsAdmin');
        }
        return $this->render('admin/forms/Aj_plat.html.twig', array('f' => $form->createView()));

    }
    /**
     * @Route("/supprimerPlat{id}", name="supprimerPlat")
     */
    public function supprimerPlat($id){
        $em=$this->getDoctrine()->getManager();
        $plat=$this->getDoctrine()->getRepository(Plats::class)->find($id);
        $em->remove($plat);
        $em->flush();
        return $this->redirectToRoute('platsAdmin');

    }
    /**
     * @Route("/modifierPlat{id}", name="modifierPlat")
     */
    public function modifierRestaurants(Request $request,$id){
        $em = $this->getDoctrine()->getManager();

        $plat=$em->getRepository(Plats::class)->find($id);
        $form=$this->createForm(PlatsType::class,$plat);

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $file = $plat->getPhoto();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $plat->setPhoto($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($plat);
            $em->flush();
            return $this ->redirectToRoute('platsAdmin');
        }
        return $this->render('admin/forms/Aj_plat.html.twig', array('f' => $form->createView()));

    }
    /**
     * @Route("/plats{id}", name="plats")
     */
         public function platFront( $id,Request $request, PaginatorInterface $paginator): Response
    {
        $p=$this->getDoctrine()->getRepository(Plats::class);
        $plats=$p->findBy(['restoId'=> $id]);

        if ($request->isMethod("POST"))
        {
            $nom_plat = $request->get("nom_plat");
            $plats=$p->findBy(array("nom"=>$nom_plat));

        }

        $plats =$paginator->paginate(
          $plats,
          $request->query->getInt('page',1),
          2

        );


        return $this->render('plats/Plats.html.twig', array('plats'=>$plats));
    }

}
