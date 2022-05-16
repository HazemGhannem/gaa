<?php

namespace App\Controller;

use App\Form\ChangePasswordType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ComptePasswordController extends AbstractController
{

    private $entityManager;

    /**
     * ComptePasswordController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/modifier-mdp", name="compte_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $notification = null;
        $user= $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid())
        {
            $old_password = $form->get('old_password')->getData();
            if($encoder->isPasswordValid($user,$old_password)){
                $new_password = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user,$new_password);
                $user->setPassword($password);
                $this->entityManager->flush();
                $notification = "votre mot de passe a bien été mise à jour";

                
            }else { $notification= "votre mot de passe actuel n'est pas le bon"; }


        }






        return $this->render('compte/password.html.twig', [
            'form' => $form->createView() ,
            'notification' => $notification
            ]);
    }
}
