<?php

namespace App\Controller;

use App\Entity\Plats;
use App\Entity\Restaurants;
use App\Form\PlatsType;
use App\Form\RestaurantsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;
class RestaurantsController extends AbstractController
{
    /**
     * @Route("/restaurants", name="restaurants")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $r=$this->getDoctrine()->getRepository(Restaurants::class);
        $restaurant=$r->findAll();

        if ($request->isMethod("POST"))
        {
            $recherche = $request->get("recherche");
            $restaurant=$r->findByKey($recherche);

        }

          $restaurants = $paginator->paginate(
          $restaurant,
          $request->query->getInt('page',1),
          2

        );

        return $this->render('restaurants/Restaurants.html.twig', array('restaurants'=>$restaurants));


    }
    /**
     * @Route("/detailRest{id}", name="detailRest")
     */
    public function readRestaurant(int $id): Response
    {

        $r=$this->getDoctrine()->getRepository(Restaurants::class);
        $restaurant=$r->find($id);
        return $this->render('restaurants/det.html.twig', array('restaurant'=>$restaurant));

    }

    /**
     * @Route("admin/ajouterRestaurant", name="ajouteRestaurants")
     */
    public function ajouterRestaurants(Request $request){

        $restaurant = new Restaurants();
        $form = $this->createForm(RestaurantsType::class,$restaurant);


        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $file = $restaurant->getPhoto();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $restaurant->setPhoto($filename);
            $em =$this->getDoctrine()->getManager();
            $em->persist($restaurant);
            $em->flush();
            return $this->redirectToRoute('restaurantsAdmin');
        }
        return $this->render('admin/forms/Aj_resto.html.twig', array('f' => $form->createView()));

    }

    /**
     * @Route("admin/modifierRestaurant{id}", name="modifierRestaurant")
     */
        public function modifierRestaurants(Request $request,$id){
            $em = $this->getDoctrine()->getManager();

            $restaurant=$em->getRepository(Restaurants::class)->find($id);
            $form=$this->createForm(RestaurantsType::class,$restaurant);

            $form->handleRequest($request);

            if($form->isSubmitted()and $form->isValid()){
                $file = $restaurant->getPhoto();
                $filename = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$filename);
                $restaurant->setPhoto($filename);
                $em=$this->getDoctrine()->getManager();
                $em->persist($restaurant);
                $em->flush();
                return $this ->redirectToRoute('restaurantsAdmin');
            }
            return $this->render('admin/forms/Aj_resto.html.twig', array('f' => $form->createView()));

        }
    /**
     * @Route("admin/restaurantsAdmin", name="restaurantsAdmin")
     */
        public function afficherRestaurant(Request $request, PaginatorInterface $paginator){
            $r=$this->getDoctrine()->getRepository(Restaurants::class);
            $restaurant=$r->findAll();

            if ($request->isMethod("POST"))
            {
                $nom_resto = $request->get("nom_resto");
                $restaurant=$r->findBy(array("nom"=>$nom_resto));

            }

               $restaurant = $paginator->paginate(
                $restaurant,
                $request->query->getInt('page',1),
                1

            );
            return $this->render('admin/restaurants/restaurantsAdmin.html.twig', array('restaurants'=>$restaurant));


        }
    /**
     * @Route("admin/supprimerRestaurant{id}", name="supprimerRestaurant")
     */
        public function supprimerRestaurant($id){
            $em=$this->getDoctrine()->getManager();
            $restaurant=$this->getDoctrine()->getRepository(Restaurants::class)->find($id);
            $em->remove($restaurant);
            $em->flush();
            return $this->redirectToRoute('restaurantsAdmin');

        }






}
