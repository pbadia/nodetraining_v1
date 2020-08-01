<?php


namespace App\Controller;

use App\Repository\QuizRepository;
use phpDocumentor\Reflection\Types\Array_;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function index(QuizRepository $repository, LoggerInterface $logger){

        // If a user is connected, check if a quiz is running
        $quiz = [];
        if ($this->isGranted('ROLE_USER')) {
            $quiz = $repository->findRunningByUser($this->getUser()->getId());
        }

        // Set the quiz if it has been found
        if (!empty($quiz)) {
            $quiz = $quiz[0];
        }

        return $this->render('pages/home.html.twig', [
            'quiz' => $quiz
        ]);
    }
}