<?php

namespace App\Service;

use App\Repository\QuizRepository;
use Symfony\Component\Security\Core\Security;


class QuizService
{
    private $quizId = "";

    public function __construct(QuizRepository $repository, Security $security){

        // If a user is connected, check if a quiz is running
        $quiz = [];

        if ($security->isGranted('ROLE_USER')) {
            $quiz = $repository->findByUser($security->getUser()->getId(), true);
        }

        // Set the quiz as running if it has been found
        if (!empty($quiz)) {
            $this->quizId = $quiz[0]->getId();
        }
    }

    public function getQuizId(){
        return $this->quizId;
    }

    public function setQuizId(bool $quizId){
        $this->quizId = $quizId;
    }

}