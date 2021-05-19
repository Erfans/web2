<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\BookStore;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {

            $bookStore = new BookStore();
            $bookStore->setName("Shahre Ketab");
            $bookStore->setEmail("shahr@ketab.com");
            $bookStore->setPhone("2222 222");
            $manager->persist($bookStore);

            $book = new Book();
            $book->setName("book " . $i);
            $book->setDescription("book description " . $i);
            $book->setPrice(10000);
            $book->setBookStore($bookStore);
            $manager->persist($book);

            $manager->flush();
        }
    }
}
