<?php

namespace App\DataFixtures;

use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Random\RandomException;

class AppFixtures extends Fixture
{
    /**
     * @throws RandomException
     */
    public function load(ObjectManager $manager): void
    {
        QuestionFactory::new()->createMany(20);
    }
}
