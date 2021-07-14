<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\BookStore;
use App\Entity\Magazine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SalableFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $bookStore = new BookStore();
            $bookStore->setName($faker->name);
            $bookStore->setEmail($faker->email);
            $bookStore->setPhone($faker->phoneNumber);
            $manager->persist($bookStore);

            for ($j = 0; $j < 1000; $j++) {
                $book = new Book();
                $book->setName($faker->name);
                $book->setDescription($faker->text);
                $book->setPrice($faker->randomNumber(6));
                $book->setBookStore($bookStore);
                $manager->persist($book);
            }

            for ($j = 0; $j < 10; $j++) {
                $book = new Magazine();
                $book->setName($faker->name);
                $book->setDescription($faker->text);
                $book->setPrice($faker->randomNumber(6));
                $book->setBookStore($bookStore);
                $book->setIssueNumber($faker->randomNumber(3));
                $manager->persist($book);
            }

            $manager->flush();
        }
    }
}
