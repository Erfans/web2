<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
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
        $manager->flush();
    }
}
