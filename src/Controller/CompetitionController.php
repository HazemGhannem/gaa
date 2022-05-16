<?php

namespace App\Controller;
use App\Classe\Searchh;
use App\Form\SearchhType;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Classe\Search;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Form\SearchType;
use App\Repository\CompetitionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetitionController extends AbstractController
{
    /**
     * @Route("/competition", name="competition")
     * @param CompetitionRepository $CompetitionRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(CompetitionRepository $CompetitionRepository,Request $request,PaginatorInterface $paginator): Response
    {

        $competitions = $CompetitionRepository->findAll();

        if ($request->isMethod("POST"))
        {
            $competitions=$CompetitionRepository->trierdate();
        }
        $competitions= $paginator->paginate(
            $competitions,
            $request->query->getInt('page',1),
            2);
        $search = new Searchh();
        $form = $this->createForm(SearchhType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $competitions=$CompetitionRepository->findWithSearch($search);




    }
        return $this->render('competition/index.html.twig', ['competitions'=>$competitions
            ,
            "form" => $form->createView()
        ]);
    }
    /*public function index(ProductRepository $productRepository, Request $request)
    {

        $products = $productRepository->findAll();

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

        $products=$productRepository->findWithSearch($search);
        }

        return $this->render('produit/produit.html.twig',
            ['product' => $products,

,
                'form' => $form->createView()

            ]);
    }*/

    /**
     * @param CompetitionRepository $CompetitionRepository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route("admin/afficheCompetition", name="afficheCompetition")
     */
    public function getCompetitions(CompetitionRepository $CompetitionRepository,Request $request,PaginatorInterface $paginator) {
        $competitions = $CompetitionRepository->findAll();

        if ($request->isMethod("POST"))
        {
            $competitions=$CompetitionRepository->trierdate();
        }
        $competitions= $paginator->paginate(
            $competitions,
            $request->query->getInt('page',1),
            2);
        $search = new Searchh();
        $form = $this->createForm(SearchhType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $competitions=$CompetitionRepository->findWithSearch($search);
          //  $products=$productRepository->findWithSearch($search);
        }

        return $this->render('admin/competition/afficheC.html.twig',
           // ['product' => $products,
             ['competitions'=>$competitions
                ,
                "form" => $form->createView()
             ]);


    }

    /**
     * @param CompetitionRepository $repo
     * @param $idComp
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("admin/suppCompetition/{idComp}", name="suppCompetition")
     */
    public function suppCompetition(CompetitionRepository $repo, $idComp) {

        $em = $this->getDoctrine()->getManager();
        $competitionToDelete = $repo->find($idComp);
        $em->remove($competitionToDelete);
        $em->flush();

        return $this->redirectToRoute("afficheCompetition");
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("admin/ajoutCompetition",name="ajoutCompetition")
     */
    public function ajoutCompetition(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $comp = new Competition();
        $form = $this->createForm(CompetitionType::class, $comp);
        $form->add("Ajouter", SubmitType::class, array(
            'label' => 'Ajouter',
            'attr' => array(
                'class'=> "btn btn-primary mt-3"
            )
        ));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($comp);
            $em->flush();
            return $this->redirectToRoute('afficheCompetition');
        }
        return $this->render('admin/competition/ajout.html.twig', [ "form" => $form->createView() ]);
    }

    /**
     * @param $idComp
     * @param CompetitionRepository $repo
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("admin/modifCompetition/{idComp}", name="modifCompetition")
     */
    public function modifCompetition($idComp, CompetitionRepository $repo, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $comp = $repo->find($idComp);
        $form = $this->createForm(CompetitionType::class, $comp);

        $form->add("Modifier", SubmitType::class, array(
            'label' => 'Modifier',
            'attr' => array(
                'class'=> "btn btn-warning mt-3"
            )
        ));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('afficheCompetition');
        }
        return $this->render('admin/competition/ajout.html.twig', [ "form" => $form->createView() ]);
    }

    /**
     * @Route("admin/Lister", name="Lister")
     * @param CompetitionRepository $competitionRepository
     * @return Response
     */
    public function Lister(CompetitionRepository $competitionRepository):Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $competition = $competitionRepository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin/competition/lister.html.twig', [
            'competitions' => $competition,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);


    }

}
