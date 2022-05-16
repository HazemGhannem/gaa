<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\CarrierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("" )
 * @package App\Controller\Admin
 */
class AdminController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager =$entityManager;
    }

    /**
     * @Route("admin/home", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @return Response
     * @param UserRepository $userRepository
     * @Route ("admin/affiche", name="afficheA")
     */
    public function AfficheA(UserRepository $userRepository): Response
    {
        $user =$userRepository->findAll();

        $nbM =$userRepository->findOneSexeM("masculin");
        $nbF = $userRepository->findOneSexeF("feminin");




        return $this->render('admin/Users/AfficheAdmin.html.twig',
            ['user' => $user ,
                'nbm' => $nbM ,
                'nbf' => $nbF

            ]);
    }
    /**
     * @param $id
     * @param UserRepository $userRepository
     * @return RedirectResponse
     * @Route ("Users/delete/{id}", name="deleteA")
     */
    public function delete($id,UserRepository $userRepository){
        $user = $userRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute("afficheA");
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     * @Route("Users/ajouter", name="ajoutA")
     */
    public function Add(Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(InscriptionAdminType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();


            $password = $encoder->encodePassword($user, $user->getPassword());


            $user->setPassword($password);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

        }

        return $this->render('admin/Users/ajouter.html.twig',
            ['form' => $form->createView()]

        );

    }
    /**

     * @param UserRepository $userRepository
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("Users/update/{id}", name="updateA")
     */
    public function Update(UserRepository $userRepository, $id, Request $request){

        $user = $userRepository->find($id);
        $form=$this->createForm(CarrierType::class,$user);
        $form->add('update',SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('afficheA');
        }
        return $this->render('admin/Users/modifier.html.twig',
            ['form' => $form->createView()]
        );


    }
}
