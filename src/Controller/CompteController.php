<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\User;
use App\Form\ComptePhotoType;
use App\Form\InscriptionType;
use App\Form\PhotoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     */
    public function index()
    {

        return $this->render('compte/index.html.twig');



        }



    /**
     * @Route("/compte/photo", name="ajouterphoto")
     */
    public function ajouterPhoto(Request $request): Response
    {

        $form = $this->createForm(PhotoType::class, $this->getUser());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $this->getUser()->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $this->getUser()->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($this->getUser());
            $em->flush();
            return $this->redirectToRoute('compte');


        }
        return $this->render('compte/photo.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
