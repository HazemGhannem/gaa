<?php

namespace App\Controller;

use App\Entity\ReservationPlats;

use App\Entity\Plats;
use App\Entity\Restaurants;
use App\Entity\User;
use App\Form\ReservationPlatsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\PaginatorInterface;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\BarChart;

class ReservationRestoController extends AbstractController
{
    /**
     * @Route("/reservationResto", name="reservationResto")
     */
    public function index(): Response
    {
        return $this->render('reservation_resto/MesReservations.html.twig', [
            'controller_name' => 'ReservationRestoController',
        ]);
    }
    /**
     * @Route("/reservationRestoAdmin", name="reservation_resto_admin")
     */
    public function ResAdmin(Request $request, PaginatorInterface $paginator): Response
    {
        $r=$this->getDoctrine()->getRepository(ReservationPlats::class);
        $reservation=$r->findAll();


        if ($request->isMethod("POST"))
        {
            $reservation=$r->trierdate();
        }

        $reservation= $paginator->paginate(
            $reservation,
            $request->query->getInt('page',1),
            3);

        return $this->render('admin/reservation_resto/MesReservationsAdmin.html.twig', array('reservations'=>$reservation));

    }
    /**
     * @Route("/addReservationPlat{id}", name="addReservationPlat")
     */
    public function ajouterReservation(Request $request ,$id){


        $reservation = new ReservationPlats();
        $plat = $this->getDoctrine()->getRepository(Plats::class)->findOneBy(['id_plat'=>$id]);

        $reservation->setPlatId($plat);
        $reservation->setDateReservation(new \DateTime('now'));
        $reservation->setEtat(false);

        $reservation->setClientId($this->getUser());
        $form = $this->createForm(ReservationPlatsType::class,$reservation);


        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {


            $em =$this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
            return $this->redirectToRoute('MesReservationPlat');
        }
        return $this->render('forms/Aj_reserv_plat.html.twig', array('reser' => $form->createView()));

    }
    /**
     * @Route("/MesReservationPlat", name="MesReservationPlat")
     */
    public function afficherReservationP(Request $request, PaginatorInterface $paginator){
        $r=$this->getDoctrine()->getRepository(ReservationPlats::class);
        $reservation=$r->findAll();

        $reservation= $paginator->paginate(
            $reservation,
            $request->query->getInt('page',1),
            2);

        return $this->render('reservation_resto/MesReservations.html.twig', array('reservations'=>$reservation));


    }
    /**
     * @Route("/supReservationPlat{id}", name="supReservationPlat")
     */
    public function supprReservationP($id){
        $em=$this->getDoctrine()->getManager();
        $reservation=$this->getDoctrine()->getRepository(ReservationPlats::class)->find($id);
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('MesReservationPlat');

    }

    /**
     * @Route("/modReservationPlat{id}", name="modReservationPlat")
     */
    public function modifierReservationP(Request $request,$id){
        $em = $this->getDoctrine()->getManager();

        $res=$em->getRepository(ReservationPlats::class)->find($id);
        $res->setEtat(false);
        $form=$this->createForm(ReservationPlatsType::class,$res);

        $form->handleRequest($request);

        if($form->isSubmitted()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($res);
            $em->flush();
            return $this ->redirectToRoute('MesReservationPlat');
        }
        return $this->render('forms/Aj_reserv_plat.html.twig', array('reser' => $form->createView()));

    }
    /**
     * @Route ("deleteAdminReser{id}",name="deleteAdminReser")
     */
    public function DeleteAdminReser($id){
        $em=$this->getDoctrine()->getManager();
        $r=$this->getDoctrine()->getRepository(ReservationPlats::class)->find($id);
        $em->remove($r);
        $em->flush();
        return $this->redirectToRoute('reservation_resto_admin');
    }

    public function modifierEtat($id){
        $em = $this->getDoctrine()->getManager();
        $res=$em->getRepository(ReservationPlats::class)->find($id);
        $res->setEtat(true);
        $em=$this->getDoctrine()->getManager();
        $em->persist($res);
        $em->flush();

    }

    /**
     * @Route ("ComfirmationReservation{id}",name="ComfirmationReservation")
     */
    public function ComfirmationReservation($id, \Swift_Mailer $mailer){



        $reservation = $this->getDoctrine()->getRepository(ReservationPlats::class)->findOneBy(['id_resPlat'=> $id]);
        $idc = $reservation->getClientId();
        $idp = $reservation->getPlatId();
        $dt =  $reservation->getDateReservation();
        $qt = $reservation-> getQuantity();

        $client = $this->getDoctrine()->getRepository(User::class)->findOneBy(['id'=> $idc]);
        $email = $client->getEmail();
        $nom = $client->getFirstname();

        $plat = $this->getDoctrine()->getRepository(Plats::class)->findOneBy(['id_plat'=>$idp]);
        $nomp = $plat->getNom();
        $idr = $plat ->getRestoId();

        $resto = $this->getDoctrine()->getRepository(Restaurants::class)->findOneBy(['id_resto'=>$idr]);
        $nomr= $resto->getNom();

        $message = (new \Swift_Message('Confirmation Email'))
        ->setFrom('tuneasy.restaurants@gmail.com')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'admin/emails/confirmation.html.twig',
                ['nom' => $nom,
                'nomr' => $nomr,
                'nomp' => $nomp,
                'dt' => $dt,
                'qt'=>$qt]
            ),
            'text/html'
        )
    ;

    $mailer->send($message);

        $em = $this->getDoctrine()->getManager();
        $res=$em->getRepository(ReservationPlats::class)->find($id);
        $res->setEtat(true);
        $em=$this->getDoctrine()->getManager();
        $em->persist($res);
        $em->flush();

        return $this->redirectToRoute('reservation_resto_admin');


}
    /**
     * @Route("/statistiques",name="statistiques")
     */
    public function statistiques(): Response
    {
        $r=$this->getDoctrine()->getRepository(ReservationPlats::class);
        $nbs = $r->getNb();
        $p = $this->getDoctrine()->getRepository(Plats::class);



        $data = [['Plats', 'Nombre de reservations']];

        foreach($nbs as $nb)
        {
            $plat=$p->findOneBy(['id_plat'=>$nb['plat']]);
            $nomp=$plat->getNom();
            $idr = $plat ->getRestoId();

            $resto = $this->getDoctrine()->getRepository(Restaurants::class)->findOneBy(['id_resto'=>$idr]);
            $nomr= $resto->getNom();

            $aux= $nomp.":".$nomr;



            $data[] = array(
                $aux, $nb['res'])
            ;
        }
        $bar = new BarChart();
        $bar->getData()->setArrayToDataTable(
            $data
        );
        $bar->getOptions()->setTitle('Nombre de reservations par plat');
        $bar->getOptions()->getTitleTextStyle()->setColor('#07600');
        $bar->getOptions()->getTitleTextStyle()->setFontSize(25);
        return $this->render('admin/Statistiques/statistiques.html.twig', array('barchart' => $bar,'nbs' => $nbs));

    }

}
