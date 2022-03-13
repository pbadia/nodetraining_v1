<?php

namespace App\Service;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Symfony\Component\Security\Core\Security;


class QuizService
{
    private $quiz;

    public function __construct(QuizRepository $repository, Security $security){

        // If a user is connected, check if a quiz is running
        $quiz = [];

        if ($security->isGranted('ROLE_USER')) {
            $quiz = $repository->findByUser($security->getUser()->getId(), true);
        }

        // Set the quiz if it has been found
        if (!empty($quiz)) {
            $quiz = $quiz[0];
        }

        $this->quiz = $quiz;
    }

    public function getQuiz(){
        return $this->quiz;
    }

    public function setQuiz(Quiz $quiz){
        $this->quiz = $quiz;
    }

}