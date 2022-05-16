<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class MainController extends AbstractController
{
    /**
     * @Route("/change-locale/{locale}", name="change-locale")
     */
    public function changeLocale($locale, Request $request)
    {
        //On stocke la langue demandé dans la session
        $request->getSession()->set('_locale',$locale);
        //On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }
}
