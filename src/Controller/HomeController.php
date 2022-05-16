<?php

namespace App\Controller;

use App\Classe\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
       /* $mail = new Mail();
        $content = "Bonjour Youssef"."<br/>Votre inscription à été effectué avec succés";
        $mail->send('youssef.rakrouki@esprit.tn','Youssef',"Inscription revolgame",$content);*/
        return $this->render('home/index.html.twig');
    }
}
