<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Usedproduct;
use App\Repository\categoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ArtoxLab\Bundle\SmsBundle\Service\ProviderManager;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Dompdf\Dompdf;
use Dompdf\Options;
use Mediumart\Orange\SMS\SMS;
use Mediumart\Orange\SMS\Http\SMSClient;



class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="app_category")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

   
    /**
     * @Route("/afficher", name="afficher")
     */
    public function afficher(Request $request,PaginatorInterface $paginator)
    {
        $category=$this->getDoctrine()->getRepository(Category::class)->findAll();
        $category = $paginator->paginate(
            $category, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );
        return $this->render('category/afficher.html.twig',['category'=>$category]);


    }
   
    /**
     * @Route("/ajouter", name="ajouter")
     */
    public function ajouter(Request $req)
    {$category=new Category();
     $form=$this->createForm(CategoryType::class,$category);
     $form->handleRequest($req);
     if($form->isSubmitted())
     {
         $entite=$this->getDoctrine()->getManager();
     $entite->persist($category);
     $entite->flush();
     $client = SMSClient::getInstance('nEoxkRRL52MtHzUNAoaXc0ngnNVl9KDC', 'zSB1YIu2CSwoLnBL');
     $sms = new SMS($client);
     $sms->message('Une category a été ajouté')
      ->from('+21654302753')
      ->to('+21627260871')
      ->send();
     return $this->redirectToRoute('afficher');
     }
     return $this->render('category/ajouter.html.twig',['a'=>$form->createView()]);

    }
    /**
     * @Route("/supprimer/{id}", name="supprimer1")
     */
    public function supprimer($id)
    {
        $category=$this->getDoctrine()->getRepository(Category::class)->find($id);
        $a=$this->getDoctrine()->getManager();
        $a->remove($category);
        $a->flush();
        return $this->redirectToRoute('afficher');
    }
    /**
     * @Route ("/update/{id}", name="update")
     */
    public function modifier($id,Request $req)
    {
        $category=$this->getDoctrine()->getRepository(category::class)->find($id);
        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid())
        {
           $a=$this->getDoctrine()->getManager();
           $a->flush();
           return $this->redirectToRoute('afficher');
        }
        return $this->render('category/ajouter.html.twig',['a'=>$form->createView()]);
    }

      /**
     * @Route("/detail/{id}", name="detail")
     */
    public function detail($id)
    {
        $Category=$this->getDoctrine()->getRepository(Category::class)->find($id);
        $Usedproduct=$this->getDoctrine()->getRepository(Usedproduct::class)->findAll();
        $tableau= array();
        foreach ($Usedproduct as $U)
        {  if($U->getIdcategory()== $Category)
            array_push($tableau, $U);

        }
        return $this->render('category/detail.html.twig',['Usedproduct'=>$tableau]);

    }

     /**
     * @Route("/pdf", name="pdf")
     */
    public function list(categoryRepository $categoryRepository, Request $request): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $category=$categoryRepository->findAll();
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('category/pdf.html.twig', [
            'category' => $category,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A3', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Livraisons.pdf", [
            "Attachment" => false
        ]);

    
        
    }

     /**
     * @Route("/gaalouA", name="LivraisonGGGGGGGGGG")
     * Method({"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $livraison = new Category();
        $form = $this->createForm(CategoryType::class, $livraison);
         $name = $request->query->get("name");
        
       

         $livraison->setName($name);
        
       


        $form->handleRequest($request);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($livraison);
            $entityManager->flush();
          
        
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($livraison);
            return new JsonResponse("added");
    
    }

     /**
     * @Route("/Category/list/{id}", name="list-itemLL")
     */
    public function listerCategory($id): Response
    {
        $livraison = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($livraison);
       
        return new JsonResponse($formatted);
    }

     
    #update product #

    /**
     * @Route("/editAhmed/{id}",name="u")
     * Method({"GET", "POST"})
     */
    public function update($id, Request $request)
    {   
       
      
        $livraison = $this->getDoctrine()
        ->getRepository(Category::class)
        ->find($id);

        
         $name = $request->query->get("name");
        

         $livraison->setName($name);
        
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
     * @Route("/gaaloulC", name="gaaloulC", methods={"GET"})
     */
   
        public function n(): Response
    {
        $form = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($form);

         return new JsonResponse($formatted);


    }

      /**
     * @Route("/supprGaa/{id}", name="gaaaaaaaaaaaaa")
     */
    public function supprimer111($id)
    {
        $Livraison=$this->getDoctrine()->getRepository(Category::class)->find($id);
        $a=$this->getDoctrine()->getManager();
        $a->remove($Livraison);
        $a->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("done");
       
        return new JsonResponse($formatted);
    }
}
