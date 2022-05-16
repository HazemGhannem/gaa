<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Usedproduct;
use App\Entity\Urlizer;
use App\Form\UsedproductType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsedproductController extends AbstractController
{
    /**
     * @Route("/usedproduct", name="app_usedproduct")
     */
    public function index(): Response
    {
        return $this->render('front/base.html.twig', [
            'controller_name' => 'UsedproductController',
        ]);
    }


    /**
     * @Route("/afficherusedproduct", name="afficherusedproduct")
     */
    public function afficherproduct()
    {
        $Usedproduct=$this->getDoctrine()->getRepository(Usedproduct::class)->findAll();
       
        return $this->render('usedproduct/affichageproduit.html.twig',['Usedproduct'=>$Usedproduct]);


    }
   
    /**
     * @Route("/afficherU", name="afficherU")
     */
    public function afficher(Request $request,PaginatorInterface $paginator)
    {
        $Usedproduct=$this->getDoctrine()->getRepository(Usedproduct::class)->findAll();
        $Usedproduct = $paginator->paginate(
            $Usedproduct, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            1 /*limit per page*/
        );
        return $this->render('usedproduct/afficher.html.twig',['Usedproduct'=>$Usedproduct]);


    }
   
    /**
     * @Route("/ajouterU", name="ajouterU")
     */
    public function ajouter(Request $req)
    {$Usedproduct=new Usedproduct();
     $form=$this->createForm(UsedproductType::class,$Usedproduct);
     $form->handleRequest($req);
     if($form->isSubmitted())
     {
         /** @var UploadedFile $uploadedFile */
         $uploadedFile = $form['image']->getData();
         $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
         $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
         $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
         $uploadedFile->move(
             $destination,
             $newFilename
         );
             $Usedproduct->setImage($newFilename); 
        $entite=$this->getDoctrine()->getManager();
     $entite->persist($Usedproduct);
     $entite->flush();
     return $this->redirectToRoute('afficherU');
     }
     return $this->render('usedproduct/ajouter.html.twig',['a'=>$form->createView()]);

    }
    /**
     * @Route("/supprimerU/{id}", name="supprimer1U")
     */
    public function supprimer($id)
    {
        $Usedproduct=$this->getDoctrine()->getRepository(Usedproduct::class)->find($id);
        $a=$this->getDoctrine()->getManager();
        $a->remove($Usedproduct);
        $a->flush();
        return $this->redirectToRoute('afficherU');
    }
    /**
     * @Route ("/updateU/{id}", name="updateU")
     */
    public function modifier($id,Request $req)
    {
        $Usedproduct=$this->getDoctrine()->getRepository(Usedproduct::class)->find($id);
        $form=$this->createForm(UsedproductType::class,$Usedproduct);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
         /** @var UploadedFile $uploadedFile */
         $uploadedFile = $form['image']->getData();
         $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
         $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
         $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
         $uploadedFile->move(
             $destination,
             $newFilename
         );
             $Usedproduct->setImage($newFilename); 
           $a=$this->getDoctrine()->getManager();
           $a->flush();
           return $this->redirectToRoute('afficherU');
        }
        return $this->render('usedproduct/ajouter.html.twig',['a'=>$form->createView()]);
    }

     /**
     * @Route("/newProd", name="Livraison")
     * Method({"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $livraison = new Usedproduct();
        $form = $this->createForm(UsedproductType::class, $livraison);
         $name = $request->query->get("name");
         $description = $request->query->get("description");
        $image=$request->query->get("image");
       $prix=$request->query->get("prix");
      

        $livraison->setName($name);
        $livraison->setImage($image);
        $livraison->setDescription($description);
        $livraison->setPrix($prix);
        


        $form->handleRequest($request);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livraison);
            $entityManager->flush();
          
        
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($livraison);
            return new JsonResponse("added");
    
    }

     /**
     * @Route("/Prod/list/{id}", name="list-itemLL")
     */
    public function listerCategory($id): Response
    {
        $livraison = $this->getDoctrine()
            ->getRepository(Usedproduct::class)
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($livraison);
       
        return new JsonResponse($formatted);
    }

     
    #update product #

    /**
     * @Route("/editP/{id}",name="update_Category")
     * Method({"GET", "POST"})
     */
    public function update($id, Request $request)
    {   
       
      
        $livraison = $this->getDoctrine()
        ->getRepository(Usedproduct::class)
        ->find($id);

        
        $name = $request->query->get("name");
        $description = $request->query->get("description");
       $image=$request->query->get("image");
      $prix=$request->query->get("prix");
     

       $livraison->setName($name);
       $livraison->setImage($image);
       $livraison->setDescription($description);
       $livraison->setPrix($prix);
        
        // $livreur->setDateNaissance($dateNaissance);
       

         $form = $this->createFormBuilder($livraison)
         ->add('Done',SubmitType::class)
         ->getForm();
        $form->handleRequest($request);
          

        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush(); 

        
       
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($livraison);
        return new JsonResponse($formatted);
        // return $this->render('Product/update.html.twig', [
        //     'form' => $form->createView(),


        // ]);
    }

     /**
     * @Route("/jsonProd", name="json_indexC", methods={"GET"})
     */
   
        public function n(): Response
    {
        $form = $this->getDoctrine()
            ->getRepository(Usedproduct::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($form);

         return new JsonResponse($formatted);


    }

      /**
     * @Route("/supprimerJP/{id}", name="supprimerC")
     */
    public function supprimer111($id)
    {
        $Livraison=$this->getDoctrine()->getRepository(Usedproduct::class)->find($id);
        $a=$this->getDoctrine()->getManager();
        $a->remove($Livraison);
        $a->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("done");
       
        return new JsonResponse($formatted);
    }
}
