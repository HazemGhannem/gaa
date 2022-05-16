<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\LocationMateriel;
use App\Form\CategoryType;
use App\Form\LocationMaterielType;
use App\Repository\CarrierRepository;
use App\Repository\CategoryRepository;
use App\Repository\LocationMaterielRepository;
use phpDocumentor\Reflection\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class LocationController extends AbstractController
{
    /**
     * @Route("admin/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('transport/index.html.twig');
    }



    /**
     * @param LocationMaterielRepository $locationmaterielrepository
     * @return Response
     * @Route ("/afficheL", name="afficheL")
     */
    public function Affiche(LocationMaterielRepository $locationmaterielrepository)
    {
        $location=$locationmaterielrepository->findAll();
        return $this->render('admin/transport/Afficher.html.twig',
            ['location' => $location]);
    }

    /**
     * @param $id
     * @param LocationMaterielRepository $locationmaterielrepository
     * @Route ("delete/{id}", name="deleteL")
     */

    public function delete($id,LocationMaterielRepository $locationmaterielrepository){
        $location= $locationmaterielrepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($location);
        $em->flush();
        return $this->redirectToRoute("afficheL");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/ajoutC", name="ajoutL")
     */
    public function Add(Request $request){
        $location = new LocationMateriel();
        $form=$this->createForm(LocationMaterielType::class,$location);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();
            return $this->redirectToRoute("afficheL");
        }
        return $this->render('admin/transport/Ajouter.html.twig',
            ['form' => $form->createView()]);
    }

    /**

     * @param LocationMaterielRepository $locationmaterielrepository
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("admin/updateC/{id}", name="updateL")
     */
    public function Update(LocationMaterielRepository $locationmaterielrepository, $id, Request $request){

        $location= $locationmaterielrepository->find($id);
        $form=$this->createForm(LocationMaterielType::class,$location);
       // $form->add('Update',SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheL');
        }
        return $this->render('transport/Update.html.twig',
            ['form' => $form->createView()]
        );


    }

    /**
     * @param LocationMaterielRepository $locationmaterielrepository
     * @Route("Lister", name="Lister")
     */
    public function Lister(LocationMaterielRepository $locationmaterielrepository):Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $location = $locationmaterielrepository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin/transport/Lister.html.twig', [
            'location' => $location,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);


    }






}
