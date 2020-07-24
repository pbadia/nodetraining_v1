<?php


namespace App\Controller;


use App\Entity\Quiz;
use App\Repository\QuestionRepository;
use App\Repository\QuizRepository;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * Class QuizController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class QuizController extends AbstractController
{
    /**
     * @var QuizRepository
     */
    private $repository;

    /**
     * QuizController constructor.
     * @param QuizRepository $repository
     */
    public function __construct(QuizRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/quiz/new", name = "quiz.new")
     * @param Security $security
     * @param QuestionRepository $questionRepository
     * @return Response
     */
    public function new(Security $security, QuestionRepository $questionRepository, LoggerInterface $logger){
        // Get the current logged on user
        $user = $this->getUser();

        // Pick random questions for the quiz
        $questions = $questionRepository->findRandomResultsQuery(5);

        // Create the quiz for the current logged on user
        $quiz = new Quiz();
        $quiz->setUser($user);

        // Create


        // Display the quiz
        return $this->render('quiz/show.html.twig', [
            'questions' => $questions,
        ]);


    }
}