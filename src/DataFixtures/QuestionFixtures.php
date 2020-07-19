<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création des thèmes
        $theme1 = new Theme();
        $theme1->setName("Ransomware");
        $manager->persist($theme1);
        $theme2 = new Theme();
        $theme2->setName("Formation");
        $manager->persist($theme2);
        $theme3 = new Theme();
        $theme3->setName("Arnaque au président");
        $manager->persist($theme3);
        $theme4 = new Theme();
        $theme4->setName("Cryotolocker");
        $manager->persist($theme4);
        $theme5 = new Theme();
        $theme5->setName("Phishing");
        $manager->persist($theme5);
        $theme0 = new Theme();
        $theme0->setName("Clé usb");
        $manager->persist($theme0);
        $theme6 = new Theme();
        $theme6->setName("Sauvegarde");
        $manager->persist($theme6);


        $faker = Factory::create('fr_FR');

        for ($i = 1; $i < 100; $i++)
        {
            $question = new Question();
            $question->setLevel(rand(0, 2));
            $r = rand(0,5);
            switch ($r) {
                case 0 :
                    $question->addTheme($theme0); break;
                case 1 :
                    $question->addTheme($theme1); break;
                case 2 :
                    $question->addTheme($theme2); break;
                case 3 :
                    $question->addTheme($theme3); break;
                case 4 :
                    $question->addTheme($theme4); break;
                case 5 :
                    $question->addTheme($theme5);
            }
            $r = rand(0, 1);
            if ($r == 1) $question->addTheme($theme6);
            $question->setLabel($faker->sentence());

            $manager->persist($question);
        }

        $manager->flush();
    }
}
