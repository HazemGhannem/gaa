<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;

use App\Form\ContactType;
use App\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,\Swift_Mailer $mailer){
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid()) {

    $contact = $form->getData();
    $message = (new \Swift_Message('Mail Tuneasy User'))
    ->setFrom($contact['email'])->setTo('wiem.mejri@esprit.tn')
        ->setBody($this->renderView('email/contact.html.twig',compact('contact')),'text/html');
    $mailer->send($message);
    $this->addFlash('message','le message a été bien envoyé!');

        return $this->redirectToRoute('AfficheEvenements');
    }

        return $this->render('contact/index.html.twig', [
            'contact_form' => $form->createView()
        ]);
    }
}
