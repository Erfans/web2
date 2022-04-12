<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\BookStore;
use App\Entity\Magazine;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SalableFixtures extends Fixture
{

    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(
        UserPasswordEncoderInterface $userPasswordEncoder
    )
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("erfan@web2.com");
        $user->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        $user->setPassword(
            $this->userPasswordEncoder->encodePassword($user, "1234")
        );

        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail("erfan2@web2.com");
        $user2->setRoles(['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
        $user2->setPassword(
            $this->userPasswordEncoder->encodePassword($user2, "1234")
        );

        $manager->persist($user2);

        $manager->flush();


        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $bookStore = new BookStore();
            $bookStore->setName($faker->name);
            $bookStore->setEmail($faker->email);
            $bookStore->setPhone($faker->phoneNumber);
            $bookStore->setOwner($user);
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

        for ($i = 0; $i < 10; $i++) {
            $bookStore = new BookStore();
            $bookStore->setName($faker->name);
            $bookStore->setEmail($faker->email);
            $bookStore->setPhone($faker->phoneNumber);
            $bookStore->setOwner($user2);
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
