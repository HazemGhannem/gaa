<?php

namespace App\Controller;

use App\Entity\Photo;

use App\Form\ComptePhotoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComptePhotoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager=$entityManager;

    }
    /**
     * @Route("/compte/photo", name="compte_photo")
     */
    public function index(Request $request): Response
    {
        $photo = new Photo();
        $form = $this->createForm(ComptePhotoType::class, $photo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $photo = $form->getData();
            $file = $photo->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $photo->setImage($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
            return $this->redirectToRoute('compte');

        }
        return $this->render('compte/photo.html.twig', [
            'photo'=>$photo,
            'form' => $form->createView()
        ]);
    }
}
