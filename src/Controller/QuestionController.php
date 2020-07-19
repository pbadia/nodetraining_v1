<?php


namespace App\Controller;


use App\Entity\Question;
use App\Entity\QuestionSearch;
use App\Form\QuestionSearchType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @var QuestionRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(QuestionRepository $repository, EntityManagerInterface  $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/questions", name = "question.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request) : Response
    {
        $search = new QuestionSearch();
        $form = $this->createForm(QuestionSearchType::class, $search);
        $form->handleRequest($request);

        $questions = $paginator->paginate($this->repository->findAllQuery($search),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/);

        return $this->render('question/index.html.twig', [
                'questions' => $questions,
                'form'      => $form->createView()
            ]);
    }

    /**
     * @Route("/questions/{slug}-{id}", name="question.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Question $question
     * @param string $slug
     * @return Response
     */
    public function show(Question $question, string $slug) : Response
    {
        if ($question->getSlug() !== $slug)
        {
            return $this->redirectToRoute('question.show', [
                'id' => $question->getId(),
                'slug' => $question->getSlug()
            ], 301);
        }
        return $this->render('question/show.html.twig', [
            'question' => $question
        ]);
    }
}