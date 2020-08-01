<?php


namespace App\Controller;


use App\Entity\Quiz;
use App\Entity\QuizQuestion;
use App\Form\QuizQuestionType;
use App\Repository\QuestionRepository;
use App\Repository\QuizQuestionRepository;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * QuizController constructor.
     * @param QuizRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(QuizRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/quiz/new", name = "quiz.new")
     * @param QuestionRepository $questionRepository
     * @return Response
     */
    public function new(QuestionRepository $questionRepository){

        // Check if a user is actually connected
        $this->denyAccessUnlessGranted('ROLE_USER');

        // Get the current logged on user
        $user = $this->getUser();

        // Pick random questions for the quiz
        $questions = $questionRepository->findRandomResultsQuery(5);

        // Create the quiz for the current logged on user
        $quiz = new Quiz();
        $quiz->setUser($user);

        // Create the QuizQuestion items
        foreach ($questions as $question)
        {
            $qq = new QuizQuestion();
            $qq->setQuiz($quiz);
            $qq->setQuestion($question);
            $this->em->persist($qq);

            $quiz->addQuizQuestion($qq);
        }
        $this->em->persist($quiz);
        $this->em->flush();

        return $this->redirectToRoute('quiz.play', [
            'id' => $quiz->getId()]);

    }

    /**
     * @Route("/quiz/{id}", name="quiz.play", methods="GET|POST")
     * @param Quiz $quiz
     * @param Request $request
     * @param QuizQuestionRepository $quizQuestionRepository
     * @return RedirectResponse|Response
     */
    public function play(Quiz $quiz, Request $request, QuizQuestionRepository $quizQuestionRepository)
    {
        // Check if the current user can access this quiz
        $this->denyAccessUnlessGranted('QUIZ_VIEW', $quiz);
        // Gets a quizQuestion item that has not been answered
        $quizQuestion = $quizQuestionRepository->findNotAnswered($quiz->getId());

        // If all the questions have been answered
        if (empty($quizQuestion))
        {
            // Render the quiz results
            return $this->redirectToRoute('question.index');
            /*return $this->render('question/index.html.twig', [
                'quiz' => $quiz,
            ]);*/
        }

        $quizQuestion = $quizQuestion[0];

        // Create the form
        $form = $this->createForm(QuizQuestionType::class, $quizQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($quizQuestion);
            $this->em->flush();
            return $this->redirectToRoute('quiz.play', [
                'id' => $quiz->getId()]);
        }

        // Display the quiz
        return $this->render('quiz/show.html.twig', [
            'form' => $form->createView(),
            'quizquestion' => $quizQuestion
        ]);
    }
}