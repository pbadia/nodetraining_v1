<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 10; $i++)
        {
            $question = new Question();
            $question->setLevel(rand(0, 2));
            $question->setLabel('Quel est le risque dans ce cas n°' . $i . '?');

            $manager->persist($question);
        }

        $manager->flush();
    }
}
