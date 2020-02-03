<?php

namespace App\DataFixtures;

use App\Entity\Band;
use App\Entity\Musician;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MusicianFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $musician = new Musician();
        $musician->setUserName('LucasThvn');
        $musician->setEmail('lucas@gmail.com');
        $musician->setPassword($this->passwordEncoder->encodePassword(
            $musician,
            'lucas'
        ));
        $musician->setRoles(['ROLE_BAND']);
        $manager->persist($musician);

        $manager->flush();
    }
}
