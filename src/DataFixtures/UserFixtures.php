<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("toto@gmail.com");
        $user->setPassword($this->encoder->encodePassword(
            $user,
            '123'
        ));
        $user->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user);

        $user = new User();
        $user->setEmail("tata@gmail.com");
        $user->setPassword($this->encoder->encodePassword(
            $user,
            '123'
        ));

        $manager->flush();
    }
}


