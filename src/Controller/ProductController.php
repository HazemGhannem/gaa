<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Form\SearchType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/nos-produit", name="products")
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return Response
     */
    public function index(ProductRepository $productRepository, Request $request)
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
                'form' => $form->createView()

            ]);
    }


    /**
     * @param $id
     * @param ProductRepository $productRepository
     * @return RedirectResponse|Response
     *  * @Route("/nos-produit/{id}", name="product")
     */
    public function show($id , ProductRepository $productRepository){


        $product = $productRepository->find($id);
        if(!$product){
            return $this->redirectToRoute("products");
        }

        return $this->render('produit/show.html.twig',
            ['produit' => $product]);


    }


    /**
     * @param ProductRepository $productRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @Route ("admin/product/affiche", name="afficheP")
     */
    public function Affiche(ProductRepository $productRepository, PaginatorInterface $paginator , Request $request)
    {
        $product = $productRepository->findAll();

        $product = $paginator->paginate(
            $product,
            $request->query->getInt('page',1),
            2

        );



        return $this->render('admin/product/affiche.html.twig',
            ['product' => $product]);
    }

    /**
     * @param $id
     * @param ProductRepository $productRepository
     * @Route ("admin/product/delete/{id}", name="deleteP")
     */

    public function delete($id,ProductRepository $productRepository){
        $product = $productRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute("afficheP");
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("admin/product/ajouter", name="ajoutP")
     */
    public function Add(Request $request){
        $product = new Product();
        $form=$this->createForm(ProductType::class,$product);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $product->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $product->setImage($fileName);
            $em=$this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("afficheP");
        }
        return $this->render('admin/product/ajouter.html.twig',
            ['form' => $form->createView()]);
    }

    /**

     * @param ProductRepository $productRepository
     * @param $id
     * @param Request $request
     * @return RedirectResponse|Response
     * @Route("admin/product/update/{id}", name="updateP")
     */
    public function Update(ProductRepository $productRepository, $id, Request $request){

        $product = $productRepository->find($id);
        $form=$this->createForm(ProductType::class,$product);
        $form->add('Update',SubmitType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $product->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
             $file->move($this->getParameter('upload_directory'), $fileName);
            $product->setImage($fileName);




             $em=$this->getDoctrine()->getManager();
             $em->flush();
            return $this->redirectToRoute('afficheP');
        }
        return $this->render('admin/product/modifier.html.twig',
            ['form' => $form->createView()]
        );


    }
}
