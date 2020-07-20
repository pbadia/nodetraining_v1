<?php


namespace App\Controller\Backend;


use App\Entity\Question;
use App\Entity\QuestionSearch;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminQuestionController
 * @package App\Controller\Backend
 * @IsGranted("ROLE_ADMIN")
 */
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

    public function __construct(QuestionRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/question", name="admin.question.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $questions = $paginator->paginate($this->repository->findAllQuery(new QuestionSearch()),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/);

        return $this->render('admin/question/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/admin/question/new", name="admin.question.new")
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

        // Store the answers as they were before the update
        $originalAnswers = new ArrayCollection();
        foreach ($question->getAnswers() as $answer)
        {
            $originalAnswers->add($answer);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($originalAnswers as $answer)
            {
                // Check if the answer has been removed, delete it in the database if true
                if (false === $question->getAnswers()->contains($answer))
                {
                    $this->em->remove($answer);
                }
            }

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