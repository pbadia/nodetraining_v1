<?php


namespace App\Controller;


use App\Entity\Question;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @return Response
     */
    public function index()
    {
        $lastQuestions = $this->repository->findLatest();
        return $this->render('question/index.html.twig', [
                'questions' => $lastQuestions
            ]);
    }
}