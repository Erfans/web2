<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/{user_id}/{product_id}", name="new_order")
     * @ParamConverter("user", options={"mapping": {"user_id": "id"}})
     * @ParamConverter("book", options={"mapping": {"product_id": "id"}})
     */
    public function newOrder(User $user, Book $book, EntityManagerInterface $entityManager): Response
    {
        $order = new Order();

        $order->setProduct($book);
        $order->setUser($user);

        $entityManager->persist($order);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'You have successfully ordered a book.'
        );

        return $this->redirectToRoute('book_index');
    }
}
