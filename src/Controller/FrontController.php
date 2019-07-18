<?php

namespace App\Controller;


use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\ContactType;
use App\Entity\SubCategory;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use App\EventListener\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(CategoryRepository $repo)
    {
        return $this->render('front/index.html.twig', [
            'categories' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/category/{id}", name="sub_category")
     */
    public function categoryAction(Category $categorie, ProductRepository $repo)
    {
        return $this->render("front/produits.html.twig", [
            'produits' => $repo->findByCategory($categorie),
            'categorie' => $categorie
        ]);
    }



    /**
     * @Route("/produit/{id}", name="show_produit")
     */
    public function showProduit(Product $produit)
    {

        return $this->render('front/produit.html.twig', [
            'produit' => $produit,
        ]);
    }


    public function libelleCategorie(CategoryRepository $repo)
    {
        return $this->render('front/categories.html.twig', [
            'categories' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function searchBar(Request $request, ProductRepository $repo, CategoryRepository $repoCat)
    {
        $em = $this->getDoctrine()->getManager();

        $prd = $request->get('q');
        $categorie = $request->get('cat');


        if (empty($categorie)) {
            $produits = $repo->findAll();
        } else {
            $produits = $repo->findByCategory($repoCat->find([
                'id' => $categorie
            ]));
        }




        return $this->render('front/produitsRecherche.html.twig', [
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/contact" , name="contact")
     */
    public function contact(Request $request, ContactNotification $contactNotification)
    {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactNotification->notify($contact);
            //$this->addFlash('success', 'message sent successfully!');
            //return $this->redirectToRoute('contact');
        }
        return $this->render('front/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
