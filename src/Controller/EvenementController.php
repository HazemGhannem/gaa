<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EvenementType;
use Symfony\Contracts\Translation\TranslatorInterface;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
        ]);
    }

    /**
     * @param EvenementRepository $repo
     * @return Response
     * @Route ("/AfficheE", name= "AfficheEvenements")
     */
    public function afficheEvenements(EvenementRepository  $repo,Request $request){
       // $repo = $this->getDoctrine()->getRepository(Evenement::class);
        if ($request->isMethod("POST"))
        {
            $recherche = $request->get("recherche");
            $evenement= $repo->findByKey($recherche);

        }
else
        $evenement= $repo->findAll();
        return $this->render('evenement/afficheEvenement.html.twig',
        ['evenement'=>$evenement]);


    }

    /**
     * @param $id
     * @param EvenementRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("SupprimerE/{id}", name="supprimerE")
     */
    public function SupprimerEve($id, EvenementRepository  $repository){
        $evenement = $repository ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('AfficheEvenements');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/evenement/AjouterE", name="ajoutE")
     */

    public function AjouterEve(Request  $request, TranslatorInterface $translator){
        $evenement= new Evenement();

        $form = $this->createForm(EvenementType::class,$evenement);

        $form->handleRequest($request);
        $evenement->setNombreVus(1);
        $evenement->setNombreParticipants(1);
        $evenement->setApprouver(true);
        if($form->isSubmitted() && $form->isValid()){

                $uploadedFile = $evenement->getPhoto();
                $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($this->getParameter('upload_directory'),$filename);
                $evenement->setPhoto($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            $message = $translator->trans('Event added successfully');
            $this->addFlash('info',$message);
            return $this->redirectToRoute('AfficheEvenements');

        }
        return $this->render('evenement/ajoutEvenement.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param EvenementRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/evenement/ModifierE/{id}", name="modifierE")
     */
    public function Modifier(EvenementRepository  $repository, $id,Request $request){
        $evenement =$repository->find($id);
        $form=$this->createForm(EvenementType::class,$evenement);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $uploadedFile = $evenement->getPhoto();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $evenement->setPhoto($filename);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheEvenements');
        }
        return $this->render('evenement/modifierEvenement.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param EvenementRepository $repo
     * @param $id
     * @return Response
     * @Route ("/evenement/AfficheUnE/{id}", name="AfficheUnE")
     */
    public function afficheUnEvenement(EvenementRepository  $repo,$id){
        // $repo = $this->getDoctrine()->getRepository(Evenement::class);

        $e= $repo->find($id);
        return $this->render('evenement/afficheUnEvenement.html.twig',
            ['e'=>$e]);


    }

    /**
     * @param EvenementRepository $repo
     * @return Response
     * @Route ("/AfficheEPublic", name= "AfficheEvenementsPublic")
     */
    public function afficheEvenementsPublic(EvenementRepository  $repo,Request $request, PaginatorInterface $paginator){
        // $repo = $this->getDoctrine()->getRepository(Evenement::class);

            $evenement= $repo->findAll();
            $articles = $paginator->paginate(
                $evenement, // Requête contenant les données à paginer (ici nos articles)
                $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                1 // Nombre de résultats par page
            );

        return $this->render('evenement/afficheEvenementPublic.html.twig',
            ['articles'=>$articles]);


    }
    /**
     * @param EvenementRepository $repo
     * @return Response
     * @Route("admin/adminAfficherE",name="admin_afficherE")
     */

    public function Affiche_Admin(EvenementRepository $repo )
    {
        $evenement=$repo->findAll();
        return $this->render('admin/evenement/afficheE.html.twig',['evenement'=>$evenement]);
    }

    /**
     * @param $id
     * @param EvenementRepository $repo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("admin/delete_evenement_admin/{id}", name="delete_evenementadmin")
     */

    public function Delete_logement_admin($id, EvenementRepository $repo)
    {
        $evenement=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('admin_afficherE');
    }
    /**
     * @param EvenementRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("admin/evenement/ModifierEadmin/{id}", name="modifierEadmin")
     */
    public function ModifierAdmin(EvenementRepository  $repository, $id,Request $request){
        $evenement =$repository->find($id);
        $form=$this->createForm(EvenementType::class,$evenement);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $uploadedFile = $evenement->getPhoto();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $evenement->setPhoto($filename);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheEvenements');
        }
        return $this->render('admin/evenement/adminModifierEvenement.html.twig',[
            'form'=>$form->createView()
        ]);
    }



}
