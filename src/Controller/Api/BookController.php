<?php

namespace App\Controller\Api;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class BookController
 * @package App\Controller\Api
 *
 * @Route("/api", name="api_book")
 */
class BookController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/book.{_format}", name="api_book_list", format="html")
     */
    public function list(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();
        return $this->handleView(new View(['books' => $books]));
    }

    /**
     * @Rest\Get("/book/{id}.{_format}", name="api_book_show", format="html")
     */
    public function show(Book $book): Response
    {
        return $this->handleView(new View(['book' => $book]));
    }

    /**
     * @Rest\Post("/book.{_format}", name="api_book_new", format="html")
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);
        if ($form->isValid()) {

        }


        return $this->handleView(new View(['book' => $book]));
    }
}
