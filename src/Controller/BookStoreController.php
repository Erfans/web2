<?php

namespace App\Controller;

use App\Entity\BookStore;
use App\Form\BookStoreType;
use App\Repository\BookStoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/book-store")
 */
class BookStoreController extends AbstractController
{
    /**
     * @Route("/", name="book_store_index", methods={"GET"})
     */
    public function index(BookStoreRepository $bookStoreRepository): Response
    {
        return $this->render('book_store/index.html.twig', [
            'book_stores' => $bookStoreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="book_store_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bookStore = new BookStore();
        $form = $this->createForm(BookStoreType::class, $bookStore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookStore);
            $entityManager->flush();

            return $this->redirectToRoute('book_store_index');
        }

        return $this->render('book_store/new.html.twig', [
            'book_store' => $bookStore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_store_show", methods={"GET"})
     */
    public function show(BookStore $bookStore): Response
    {
        return $this->render('book_store/show.html.twig', [
            'book_store' => $bookStore,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_store_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BookStore $bookStore, $_locale): Response
    {
        $this->denyAccessUnlessGranted('edit', $bookStore);

        $form = $this->createForm(BookStoreType::class, $bookStore);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bookStore->setTranslatableLocale($_locale);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_store_index');
        }

        return $this->render('book_store/edit.html.twig', [
            'book_store' => $bookStore,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_store_delete", methods={"POST"})
     */
    public function delete(Request $request, BookStore $bookStore): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bookStore->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bookStore);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_store_index');
    }
}
