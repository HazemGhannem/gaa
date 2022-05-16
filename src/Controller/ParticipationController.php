<?php

namespace App\Controller;
use App\Form\ParticipationEveType;
use App\Repository\ParticipationEveRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ParticipationEve;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormTypeInterface;
class ParticipationController extends AbstractController
{
    /**
     * @Route("/participation", name="participation")
     */
    public function index(): Response
    {
        return $this->render('participation/index.html.twig', [
            'controller_name' => 'ParticipationController',
        ]);
    }

    /**
     * @param ParticipationEveRepository $repo
     * @return Response
     * @Route("AfficheP",name="AfficheParticipations")
     */
    public function afficheParticipations(){
        $repo = $this->getDoctrine()->getRepository(ParticipationEve::class);
        $participation= $repo->findAll();
        return $this->render('participation/afficheParticipation.html.twig',
            ['participation'=>$participation]);


    }

    /**
     * @param $id
     * @param ParticipationEveRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/SupprimerP/{id}", name="supprimerP")
     */
    public function SupprimerPar($id, ParticipationEveRepository   $repository){
        $participation = $repository ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($participation);
        $em->flush();
        return $this->redirectToRoute('AfficheParticipations');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("Participation/AjouterP", name="ajoutPa")
     */
    public function AjouterPar(Request  $request){
        $participation= new ParticipationEve();

        $form = $this->createForm(ParticipationEveType::class,$participation);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($participation);
            $em->flush();
            return $this->redirectToRoute('AfficheParticipations');

        }
        return $this->render('participation/ajoutParticipation.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param ParticipationEveRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/participation/ModifierP/{id}", name="modifierP")
     */
    public function ModifierPar(ParticipationEveRepository   $repository, $id,Request $request){
        $participation =$repository->find($id);
        $form=$this->createForm(ParticipationEveType::class,$participation);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheParticipations');
        }
        return $this->render('participation/modifierParticipation.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @param ParticipationEveRepository $repo
     * @return Response
     * @Route("admin/adminAfficherP",name="admin_afficherP")
     */

    public function Affiche_Admin(ParticipationEveRepository $repo )
    {
        $participation=$repo->findAll();
        return $this->render('admin/participation/afficheP.html.twig',['participation'=>$participation]);
    }

    /**
     * @param $id
     * @param ParticipationEveRepository $repo
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("admin/delete_participation_admin/{id}", name="delete_participationadmin")
     */

    public function Delete_participation_admin($id, ParticipationEveRepository $repo)
    {
        $participation=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($participation);
        $em->flush();
        return $this->redirectToRoute('admin_afficherP');
    }
    /**
     * @param ParticipationEveRepository $repository
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("admin/participation/ModifierPadmin/{id}", name="modifierPadmin")
     */
    public function ModifierAdmin(ParticipationEveRepository $repository, $id,Request $request){
        $participation =$repository->find($id);
        $form=$this->createForm(ParticipationEveRepository::class,$participation);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $uploadedFile = $participation->getPhoto();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $participation->setPhoto($filename);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('AfficheParticipations');
        }
        return $this->render('admin/participation/modifP.html.twig',[
            'form'=>$form->createView()
        ]);
    }


}
