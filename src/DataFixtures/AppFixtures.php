<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CategoryFactory::createMany(200);
        UserFactory::createMany(200);
        PostFactory::createMany(500,[
            'user' => UserFactory::random(),
            'category' => CategoryFactory::randomRange(1,5)
        ]);

        $manager->flush();
    }
}
