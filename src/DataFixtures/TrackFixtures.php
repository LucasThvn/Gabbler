<?php

namespace App\DataFixtures;

use App\Entity\Track;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class TrackFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');
        for ($i = 1; $i < 4; $i++) {
            $track = new Track();
            $track->setName($faker->sentence(3));
            $track->setOwner($faker->name);
            $track->setFolder($this->getReference('folder_0'));
            $manager->persist($track);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [FolderFixtures::class];
    }

}
