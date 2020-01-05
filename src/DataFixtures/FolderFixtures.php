<?php

namespace App\DataFixtures;

use App\Entity\Folder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class FolderFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');

        for ($i = 0; $i < 3; $i++) {
            $folder = new Folder();
            $folder->setName($faker->word);
            $this->addReference('folder_' . $i, $folder);
            $manager->persist($folder);
        }

        $manager->flush();
    }
}
