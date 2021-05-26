<?php

namespace App\Controller;

use App\Search\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, SearchService $searchBook): Response
    {
        $q = $request->query->get('query');
        $books = $searchBook->searchBook($q);

        return $this->render('search/index.html.twig', [
            'query' => $q,
            'books' => $books
        ]);
    }
}
