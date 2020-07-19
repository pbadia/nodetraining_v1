<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < 100; $i++)
        {
            $question = new Question();
            $question->setLevel(rand(0, 2));
            $question->setLabel($faker->sentence());
            
            $manager->persist($question);
        }

        $manager->flush();
    }
}
