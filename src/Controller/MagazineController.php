<?php

namespace App\Controller;

use App\Entity\Magazine;
use App\Form\MagazineType;
use App\Repository\MagazineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/magazine")
 */
class MagazineController extends AbstractController
{
    /**
     * @Route("/", name="magazine_index", methods={"GET"})
     */
    public function index(MagazineRepository $magazineRepository): Response
    {
        return $this->render('magazine/index.html.twig', [
            'magazines' => $magazineRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="magazine_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $magazine = new Magazine();
        $form = $this->createForm(MagazineType::class, $magazine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($magazine);
            $entityManager->flush();

            return $this->redirectToRoute('magazine_index');
        }

        return $this->render('magazine/new.html.twig', [
            'magazine' => $magazine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="magazine_show", methods={"GET"})
     */
    public function show(Magazine $magazine): Response
    {
        return $this->render('magazine/show.html.twig', [
            'magazine' => $magazine,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="magazine_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Magazine $magazine): Response
    {
        $form = $this->createForm(MagazineType::class, $magazine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('magazine_index');
        }

        return $this->render('magazine/edit.html.twig', [
            'magazine' => $magazine,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="magazine_delete", methods={"POST"})
     */
    public function delete(Request $request, Magazine $magazine): Response
    {
        if ($this->isCsrfTokenValid('delete'.$magazine->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($magazine);
            $entityManager->flush();
        }

        return $this->redirectToRoute('magazine_index');
    }
}
