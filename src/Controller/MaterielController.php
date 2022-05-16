<?php

namespace App\Controller;

use App\Classe\Searchh;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Form\SearchhType;
use App\Form\SearchType;
use App\Repository\MaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class MaterielController extends AbstractController
{
    /**
     * @Route("/afficheM2", name="afficheM2")
     * @param MaterielRepository $materielRepository
     * @param Request $request
     * @return Response
     */
    public function index(MaterielRepository $materielRepository, Request $request)
    {

        $materiels = $materielRepository->findAll();

        $search = new Searchh();
        $form = $this->createForm(SearchhType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

            $materiels=$materielRepository->findWithSearch($search);
        }

        return $this->render('materiel/Afficher.html.twig',
            ['materiel' => $materiels,
                'form' => $form->createView()

            ]);
    }


    /**
     * @param $id
     * @param MaterielRepository $materielRepository
     * @return RedirectResponse|Response
     *  * @Route("/afficheM3/{id}", name="afficheM3")
     */
    public function show($id , MaterielRepository $materielRepository){


        $materiel = $materielRepository->find($id);
        if(!$materiel){
            return $this->redirectToRoute("materiels");
        }

        return $this->render('afficher.html.twig',
            ['materiel' => $materiel]);


    }


    /**
     * @param MaterielRepository $materielRepository
     * @return Response
     * @Route ("afficheM", name="afficheM")
     */
    public function Affiche(MaterielRepository $materielRepository, Request $request, PaginatorInterface $paginator)
    {
        $materiels = $materielRepository->findAll();

        if ($request->isMethod("POST"))
        {
            $materiels=$materielRepository->trierdate();
        }
        $materiels= $paginator->paginate(
            $materiels,
            $request->query->getInt('page',1),
            3);

        $search = new Searchh();
        $form = $this->createForm(SearchhType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

            $materiels=$materielRepository->findWithSearch($search);
        }

        return $this->render('materiel/Afficher.html.twig',
            ['materiel' => $materiels,
                'form' => $form->createView()

            ]);
    }

    /**
     * @param $id
     * @param MaterielRepository $materielRepository
     * @Route ("deleteM/{id}", name="deleteM")
     */

    public function delete($id,MaterielRepository $materielRepository){
        $materiel = $materielRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($materiel);
        $em->flush();
        return $this->redirectToRoute("afficheM");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("ajoutM", name="ajoutM")
     */
    public function Add(Request $request){
        $materiel = new Materiel();
        $form=$this->createForm(MaterielType::class,$materiel);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $file = $materiel->getPhotoMateriel();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $materiel->setPhotoMateriel($fileName);

            $em=$this->getDoctrine()->getManager();
            $em->persist($materiel);
            $em->flush();
            return $this->redirectToRoute("afficheM");
        }
        return $this->render('materiel/Ajouter.html.twig',
            ['form' => $form->createView()]);
    }

    /**

     * @param MaterielRepository $materielRepository
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("updateM/{id}", name="updateM")
     */
    public function Update(MaterielRepository $materielRepository, $id, Request $request){

        $materiel = $materielRepository->find($id);
        $form=$this->createForm(MaterielType::class,$materiel);
        $form->add('UpdateM',SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){





            $em=$this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('afficheM');
        }
        return $this->render('materiel/Update.html.twig',
            ['form' => $form->createView()]
        );


    }
}
