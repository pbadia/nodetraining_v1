<?php

namespace App\Repository;

use App\Entity\QuizQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuizQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuizQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuizQuestion[]    findAll()
 * @method QuizQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuizQuestion::class);
    }

    /**
     * @param $quizId
     * @return QuizQuestion[] Returns an array of QuizQuestion objects
     */
    public function findNotAnswered($quizId)
    {
        $qb = $this->createQueryBuilder('q');
        $qb
            ->andWhere('q.quiz = :val')
            ->setParameter('val', $quizId)
            ->andWhere('q.answer IS NULL')
            //->andWhere($qb->expr()->isNotNull('q.answer'))
            ->orderBy('q.question', 'ASC')
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?QuizQuestion
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
