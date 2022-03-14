<?php


namespace App\Controller;

use App\Repository\QuizRepository;
use App\Service\QuizService;
use phpDocumentor\Reflection\Types\Array_;
use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param QuizService $quizService
     * @return Response
     */
    public function index(QuizService $quizService){

        return $this->render('pages/home.html.twig', [
            'quizId' => $quizService->getQuizId()
        ]);
    }
}