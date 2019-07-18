<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        // fix administrateur
        $user = new User();
        $user->setEmail("guembrinourhene@gmail.com")
            ->setRoles("ROLE_ADMIN")
            ->setPassword($this->encoder->encodePassword($user, '123456789'))
            ->setFisrtName("guembri")
            ->setLastName("nourhene")
            ->setAddress("addresse")
            ->setTelephone("25312654")
            ->setCompany("company name ");
        $manager->persist($user);


        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setEmail("user$i@email.com")
                ->setRoles("ROLE_USER")
                ->setPassword($this->encoder->encodePassword($user, '123456789'))
                ->setFisrtName("Fname-$i")
                ->setLastName("Lname-$i")
                ->setAddress("addresse" . $i)
                ->setTelephone($i . "25" . $i . "32145" . $i)
                ->setCompany("company " . $i);

            $manager->persist($user);
        }


        $manager->flush();
    }
}
