<?php

namespace App\Repository;

use App\Entity\QuizQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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
            ->andWhere('q.answer is null')
            //->having('count(q.answers) = 0')
            //->andWhere('q.answer IS NULL')
            ->orderBy('q.number', 'ASC')
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $quizId
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findNumberAnswered($quizId)
    {
        $qb = $this->createQueryBuilder('q');
        $qb
            ->select('count(q.id)')
            ->andWhere('q.quiz = :val')
            ->setParameter('val', $quizId)
            ->andWhere('q.answer is not null')
        ;

        return $qb->getQuery()->getSingleScalarResult();
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
