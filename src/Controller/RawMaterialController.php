<?php

namespace App\Controller;

use App\Entity\RawMaterial;
use App\Form\RawMaterialType;
use App\Repository\RawMaterialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\DBALException;

/**
 * @Route("/dashboard/raw/material")
 */
class RawMaterialController extends AbstractController
{
    /**
     * @Route("/", name="raw_material_index", methods={"GET"})
     */
    public function index(RawMaterialRepository $rawMaterialRepository): Response
    {
        return $this->render('raw_material/index.html.twig', [
            'raw_materials' => $rawMaterialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="raw_material_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rawMaterial = new RawMaterial();
        $form = $this->createForm(RawMaterialType::class, $rawMaterial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rawMaterial);
            $entityManager->flush();

            return $this->redirectToRoute('raw_material_index');
        }

        return $this->render('raw_material/new.html.twig', [
            'raw_material' => $rawMaterial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="raw_material_show", methods={"GET"})
     */
    public function show(RawMaterial $rawMaterial): Response
    {
        return $this->render('raw_material/show.html.twig', [
            'raw_material' => $rawMaterial,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="raw_material_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RawMaterial $rawMaterial): Response
    {
        $form = $this->createForm(RawMaterialType::class, $rawMaterial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('raw_material_index', [
                'id' => $rawMaterial->getId(),
            ]);
        }

        return $this->render('raw_material/edit.html.twig', [
            'raw_material' => $rawMaterial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="raw_material_delete", methods={"DELETE"})
     */
    public function delete(Request $request, RawMaterial $rawMaterial): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rawMaterial->getId(), $request->request->get('_token'))) {
            try {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($rawMaterial);
                $entityManager->flush();
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->addFlash("error", "This Category can't remove !! it's have a child !!");
            }
        }

        return $this->redirectToRoute('raw_material_index');
    }
}
