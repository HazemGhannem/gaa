<?php

namespace App\Controller;


use App\Form\ReservationCompetitionType;
use App\Entity\ReservationCompetition;

use App\Repository\ReservationCompetitionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }
    /**
     * @param ReservationCompetitionRepository $repo
     * @return Response
     * @Route ("admin/afficheReservationCompetition", name="afficheReservationCompetition")
     */
    public function getReservationCompetition( ReservationCompetitionRepository  $repo )
{
 $ReservationCompetition =$repo->findAll();
 return $this->render('admin/reservation/afficheRC.html.twig',['ReservationCompetitions'=>$ReservationCompetition]);
}

/*
public function  suppReservation (ReservationCompetitionRepository $repo, $idRes): \Symfony\Component\HttpFoundation\RedirectResponse
{

    $em = $this->getDoctrine()->getManager();
    $ReservationCompetitionToDelete = $repo->find($idRes);
    $em->remove($ReservationCompetitionToDelete);
    $em->flush();
    return $this->redirectToRoute("/afficheReservationCompetition");

}
*/

/*
 *
 *
 * public function suppCompetition(CompetitionRepository $repo, $idComp) {

        $em = $this->getDoctrine()->getManager();
        $competitionToDelete = $repo->find($idComp);
        $em->remove($competitionToDelete);
        $em->flush();

        return $this->redirectToRoute("afficheCompetition");
    }
 */


    /**
     * @param ReservationCompetitionRepository $repo
     * @param $idRes
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("admin/deleteReservationCompetition/{idRes}",name="deleteReservationCompetition")
     */
 public function suppReservation(ReservationCompetitionRepository $repo, $idRes) {
     $em = $this->getDoctrine()->getManager();
     $ResToDelete = $repo->find($idRes);
     $em->remove($ResToDelete);
     $em->flush();

     return $this->redirectToRoute("afficheReservationCompetition");
 }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("admin/ajoutReservation",name="ajoutReservation")
     */

public function ajoutReservation (Request $request)
{
    $em=$this->getDoctrine()->getManager();
    $res =new ReservationCompetition();
    $form=$this->createForm(ReservationCompetitionType::class,$res);

   /* $form=$this->add("Ajouter",SubmitType::class,array(
        'label'=>"Ajouter",'attr'=>array('class'=>"btn btn-primary mt-3")
    ));*/
    $form->add("Ajouter",SubmitType::class,array(
        'label'=>'Ajouter','attr'=>array('class'=>"btn btn-primary mt-3")
    ));
$form->handleRequest($request);
if($form->isSubmitted()&& $form->isValid()){
    $em->persist($res);
    $em->flush();
    return $this->redirectToRoute('afficheReservationCompetition');
    }
return $this->render('admin/reservation/ajout.html.twig',["form"=>$form->createView()]);

}
/* public function modifCompetition($idComp, CompetitionRepository $repo, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $comp = $repo->find($idComp);
        $form = $this->createForm(CompetitionType::class, $comp);

        $form->add("Modifier", SubmitType::class, array(
            'label' => 'Modifier',
            'attr' => array(
                'class'=> "btn btn-warning mt-3"
            )
        ));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('afficheCompetition');
        }
        return $this->render('competition/ajout.html.twig', [ "form" => $form->createView() ]);
    }*/
    /**
     * @param $idRes
     * @param ReservationCompetitionRepository $repo
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("admin/modifReservation/{idRes}",name="modifReservation")
     */
public  function modifReservation ($idRes,ReservationCompetitionRepository $repo,Request $request){

    $em=$this->getDoctrine()->getManager();
    $compr=$repo->find($idRes);
    $form=$this->createForm(ReservationCompetitionType::class,$compr);
    $form->add("Modifier",SubmitType::class,array(
        'label'=>'Modifier',
        'attr'=>array(
            'class'=> "btn btn-warning mt-3"
        )
    ));
    $form->handleRequest($request);
    if($form->isSubmitted()&&$form->isValid()){
        $em->flush();
        return $this->redirectToRoute('afficheReservationCompetition');

    }
    return $this->render('admin/reservation/ajout.html.twig',["form"=>$form->createView()]);
}










}
