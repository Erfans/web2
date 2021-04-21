<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/books", name="book_list")
     */
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    }

    /**
     * @Route("/book/{id}", name="book_view")
     */
    public function view(Book $book): Response
    {
        return $this->render('book/view.html.twig', [
            'book' => $book
        ]);
    }


    /**
     * @Route("/books/new", name="book_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        if ($request->isMethod("POST")) {
            $name = $request->request->get("name");
            $description = $request->request->get("description");

            $book = new Book();
            $book->setName($name);
            $book->setDescription($description);

            $entityManager->persist($book);
            $entityManager->flush();
        }

        return $this->render('book/create.html.twig');
    }

    /**
     * @Route("/book/{id}/edit", name="book_edit")
     */
    public function edit(Book $book, Request $request, EntityManagerInterface $entityManager): Response
    {

        if ($request->isMethod("POST")) {
            $name = $request->request->get("name");
            $description = $request->request->get("description");

            $book->setName($name);
            $book->setDescription($description);

            $entityManager->flush();
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book
        ]);
    }


    /**
     * @Route("/book/{id}/delete", name="book_delete")
     */
    public function delete(Book $book, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('book_list');
    }
}
