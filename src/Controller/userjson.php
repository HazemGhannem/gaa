<?php

namespace App\Controller;

use App\Entity\Compt;
use App\Entity\Evenements;
use App\Entity\Offre;
use App\Entity\Participation;
use App\Entity\Reclamation;
use App\Entity\User;
use App\Repository\ComptRepository;
use App\Repository\EvenementsRepository;
use App\Repository\OffreRepository;
use App\Repository\ParticipationRepository;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;


/**
 * @Route ("/jsonuser")
 */
class userjson extends AbstractController
{
    ######################################afficher tous les reclamations et les offres###########################
    /**
     * @Route("/all")
     */
    public function listeuser(NormalizerInterface $Normalizer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findAll() ;
        $jsonContent=  $Normalizer->normalize($user, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));

        

    }





###########################################################################################################
##############afficher par id ##########################################################################



###########################################################################################################
##############ajouter ##########################################################################









###########################################################################################################
##############supprimer ##########################################################################




    /**
     * @Route("/delete/{id}")
     */
    public function supprimParticipation(Request $request,SerializerInterface  $serializer, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $compt=$em->getRepository(User::class)->find($id);
        $em->remove($compt);
        $em->flush();
        $jsonContent = $serializer->serialize($compt, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getIdcompt();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;


    }


###########################################################################################################
##############modifier ##########################################################################


    /**
     * @Route("/edit/{id}")
     */
    public function modifcompt(Request $request, SerializerInterface $serializer, $id, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $em = $this -> getDoctrine()->getManager();
        $compt = $em->getRepository(User::class)->find($id);
        // On hydrate l'objet
        $compt->setAge($request->get('age')) ;
        $compt->setEmail($request->get('email')) ;
        $compt->setFirstname($request->get('firstname')) ;
        $compt->setLastname($request->get('lastname')) ;
        $compt->setPassword($userPasswordEncoder->encodePassword(
            $compt,
            $request->get('password')));
        $compt->setSexe($request->get('sexe')) ;

        $compt->setRoles(["ROLE_USER"]);


        $em->flush();
        $jsonContent = $serializer->serialize($compt, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getIdcompt();
            }
        ]);


        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;

    }







    /**
     * @Route("/login")
     */
    public function login(NormalizerInterface $normalizer, Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {

        $user = new User();
        $email = $request->query->get('email');
        $password = $request->query->get('password');
        $em=$this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->findOneBy(['email'=>$email]);
//var_dump($userPasswordEncoder->isPasswordValid($user,$password));

            if ($userPasswordEncoder->isPasswordValid($user,$password)) {
                $jsonContent = $normalizer->normalize($user);
                return new Response(json_encode($jsonContent));
            } else return new Response("password incorrect");




    }
    /**
     * @Route("/add")
     */
    public function register(Request $request, NormalizerInterface $normalizer, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $compt = new User();
        $em = $this->getDoctrine()->getManager();
        $compt->setAge($request->get('age')) ;
        $compt->setEmail($request->get('email')) ;
        $compt->setFirstname($request->get('firstname')) ;
        $compt->setLastname($request->get('lastname')) ;
        $compt->setPassword($userPasswordEncoder->encodePassword(
            $compt,
            $request->get('password')));
        $compt->setSexe($request->get('sexe')) ;

        $compt->setRoles(["ROLE_USER"]);


        $em->persist($compt);
        $em->flush();


        $jsonContent = $normalizer->normalize($compt, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));;

    }




    /**
     * @Route("/all/{id}")
     */
    public function listeuserparNom(NormalizerInterface $Normalizer,$id)
    {
        $jsonContent=array();
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findAll() ;
        $output=[];
        foreach ($user as $plc){
            if($plc->getFirstname()==$id){

                $jsonContent1 = $Normalizer->normalize($plc) ;
                array_push($jsonContent,$jsonContent1);}
        }


        return new Response(json_encode($jsonContent));

    }







}
