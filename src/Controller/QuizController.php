<?php


namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use App\Form\QuizQuestionType;
use App\Repository\QuestionRepository;
use App\Repository\QuizQuestionRepository;
use App\Repository\QuizRepository;
use App\Service\QuizService;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QuizController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class QuizController extends AbstractController
{
    /**
     * @var QuizRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var QuizService
     */
    private $quizService;

    /**
     * QuizController constructor.
     * @param QuizRepository $repository
     * @param EntityManagerInterface $em
     * @param QuizService $quizService
     */
    public function __construct(QuizRepository $repository, EntityManagerInterface $em,
                                QuizService $quizService)
    {
        $this->repository = $repository;
        $this->em = $em;
        $this->quizService = $quizService;
    }

    /**
     * @Route("/quiz/new", name = "quiz.new")
     * @param QuestionRepository $questionRepository
     * @param QuizRepository $quizRepository
     * @return Response
     */
    public function new(QuestionRepository $questionRepository, QuizRepository $quizRepository){

        // Check if a user is actually connected
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Get the current logged on user
        $user = $this->getUser();

        // Check if a quiz is already running
        $quizId = $this->quizService->getQuizId();

        // If a quiz is running, redirect to it
        if ($quizId <> ""){
            return $this->redirectToRoute('quiz.play', [
                'id' => $quizId]);
        }

        // Pick random questions for the quiz
        $questions = $questionRepository->findRandomResultsQuery(5);

        // Create the quiz for the current logged on user
        $quiz = new Quiz();
        $quiz->setUser($user);

        // Set the quiz number
        $quiz->setNumber($quizRepository->getMaxNumber($user->getId()) + 1);

        // Create the QuizQuestion items
        $questionNumber = 1;
        foreach ($questions as $question)
        {
            $qq = new QuizQuestion();
            $qq->setQuiz($quiz);
            $qq->setQuestion($question);
            $qq->setNumber($questionNumber);
            $this->em->persist($qq);

            $questionNumber++;

            $quiz->addQuizQuestion($qq);
        }
        $this->em->persist($quiz);
        $this->em->flush();

        // Update global variable
        $this->quizService->setQuizId($quiz->getId());

        return $this->redirectToRoute('quiz.play', [
            'quiz' => $quiz,
            'id' => $quiz->getId()
        ]);

    }

    /**
     * @Route("/quiz/{id}", name="quiz.play", methods="GET|POST", requirements={"id"="\d+"})
     * @param Quiz $quiz
     * @param Request $request
     * @param QuizQuestionRepository $quizQuestionRepository
     * @return RedirectResponse|Response
     */
    public function play(Quiz $quiz, Request $request, QuizQuestionRepository $quizQuestionRepository)
    {
        // Check if the current user can access this quiz
        $this->denyAccessUnlessGranted('QUIZ_VIEW', $quiz);

        // Gets a collection of quizQuestion items that have not been answered
        $quizQuestion = $quizQuestionRepository->findNotAnswered($this->quizService->getQuizId());

        // If all the questions have been answered
        if (empty($quizQuestion))
        {
            // Set the quiz as finished
            $quiz->setIsRunning(false);
            $this->em->persist($quiz);
            $this->em->flush();
            $this->quizService->setQuizId("");

            // Redirect to the quiz results
            return $this->redirectToRoute('quiz.result', [
                'id' => $quiz->getId()]);
        }

        // Get the first question that has not been answered yet
        $quizQuestion = $quizQuestion[0];

        // Create the form
        $form = $this->createForm(QuizQuestionType::class, $quizQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Update the score of the quiz
            $quiz->addScore($quizQuestion->getAnswer()->getAccuracy());

            // Persist the entities
            $this->em->persist($quizQuestion);
            $this->em->persist($quiz);
            $this->em->flush();

            // Redirect to the next question
            return $this->redirectToRoute('quiz.play', [
                'id' => $quiz->getId(),
            ]);
        }


        // Display the quiz
        return $this->render('quiz/show.html.twig', [
            'form' => $form->createView(),
            'quizquestion' => $quizQuestion,
            'quiz' => $quiz,
            'quizId' => $this->quizService->getQuizId(),
        ]);
    }


    /**
     * @Route("/quiz/result/{id}", name="quiz.result")
     * @param Quiz $quiz
     * @return Response
     */
    public function result(Quiz $quiz)
    {
        // Check if the current user can access this quiz
        $this->denyAccessUnlessGranted('QUIZ_VIEW', $quiz);

        // Get the quizQuestion objects to get the results
        $quizQuestions = $quiz->getQuizQuestions();

        // Display the quiz result
        return $this->render('quiz/result.html.twig', [
            'quiz' => $quiz,
            'quizQuestions' => $quizQuestions,
            'quizId' => $this->quizService->getQuizId(),
        ]);
    }

    /**
     * @Route("/quiz/results", name="quiz.results")
     * @param PaginatorInterface $paginator
     * @param QuizRepository $repository
     * @param Request $request
     * @return Response
     */
    public function results(PaginatorInterface $paginator, QuizRepository $repository,
                            Request $request)
    {
        // TODO add filtering system for results (trophy, them, etc)

        // Check if a user is actually connected
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Get the current logged on user
        $user = $this->getUser();

        // Get the quizzes the user has played
        $quizzes = $paginator->paginate($this->repository->findByUser($user->getId()),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/);

        return $this->render('/quiz/results.html.twig', [
            'quizzes' => $quizzes,
            'trophies' => $repository->getTrophies($user->getId()),
            'quizId' => $this->quizService->getQuizId(),
        ]);

    }
}