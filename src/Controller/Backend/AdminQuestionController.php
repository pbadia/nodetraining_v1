<?php


namespace App\Controller\Backend;


use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminQuestionController extends AbstractController
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @Route("/admin", name="admin.question.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        $questions = $this->questionRepository->findAll();
        return $this->render('admin/question/index.html.twig', compact('questions'));
    }

    /**
     * @Route("/admin/{id}", name="admin.question.edit")
     * @param Question $question
     * @return Response
     */
    public function edit(Question $question) : Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        return $this->render('admin/question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView()
    ]);
    }
}