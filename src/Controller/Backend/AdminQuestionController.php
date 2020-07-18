<?php


namespace App\Controller\Backend;


use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminQuestionController extends AbstractController
{
    /**
     * @var QuestionRepository
     */
    private $questionRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(QuestionRepository $questionRepository, EntityManagerInterface $em)
    {
        $this->questionRepository = $questionRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin.question.index")
     * @return Response
     */
    public function index(): Response
    {
        $questions = $this->questionRepository->findAll();
        return $this->render('admin/question/index.html.twig', compact('questions'));
    }

    /**
     * @Route("/admin/new", name="admin.question.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) : Response
    {
        $question = new Question();

        $form = $this->createForm(questionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($question);
            $this->em->flush();
            $this->addFlash('success', 'Question ajoutée avec succès');
            return $this->redirectToRoute('admin.question.index');
        }

        return $this->render('admin/question/new.html.twig', [
            'question' => $question,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/question/{id}", name="admin.question.edit", methods="GET|POST")
     * @param Question $question
     * @param Request $request
     * @return Response
     */
    public function edit(Question $question, Request $request) : Response
    {
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Question modifiée avec succès');
            return $this->redirectToRoute('admin.question.index');
        }

        return $this->render('admin/question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView()
    ]);
    }

    /**
     * @Route("/admin/question/{id}", name="admin.question.delete", methods="DELETE")
     * @param Question $question
     * @return Response
     */
    public function delete(Question $question, Request $request) : Response
    {
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->get('_token'))) {
            $this->em->remove($question);
            $this->em->flush();
            $this->addFlash('success', 'Question supprimée avec succès');
            return $this->redirectToRoute('admin.question.index');
        }
    }
}