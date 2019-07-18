<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Form\EditProductType;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;

class StoreController extends AbstractController
{
    /**
     * @Route("/store/new", name="new_product")
     */
    public function index(Request $request)
    {

        $currentUser = $this->getUser();


        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setUser($currentUser);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('store/index.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/store/products", name="store_products")
     */
    public function list(ProductRepository $repo)
    {

        $currentUser = $this->getUser();

        $products = $repo->createQueryBuilder('p')
            ->where('p.user =:id')
            ->setParameter('id', $currentUser)
            ->getQuery()
            ->getResult();



        return $this->render('store/list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/store/{id}/edit", name="store_product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(EditProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('store_products', [
                'id' => $product->getId(),
            ]);
        }

        return $this->render('store/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
}
