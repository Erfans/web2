<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\BookStore;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $bookStore = new BookStore();
            $bookStore->setName($faker->name);
            $bookStore->setEmail($faker->email);
            $bookStore->setPhone($faker->phoneNumber);
            $manager->persist($bookStore);

            for ($j = 0; $j < 10; $j++) {
                $book = new Book();
                $book->setName($faker->name);
                $book->setDescription($faker->text);
                $book->setPrice($faker->randomNumber(6));
                $book->setBookStore($bookStore);
                $manager->persist($book);
            }

            $manager->flush();
        }
    }
}
