<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @method Answer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Answer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Answer[]    findAll()
 * @method Answer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnswerRepository extends ServiceEntityRepository
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * AnswerRepository constructor.
     * @param ManagerRegistry $registry
     * @param LoggerInterface $logger
     */
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, Answer::class);
        $this->logger = $logger;
    }

    // /**
    //  * @return Answer[] Returns an array of Answer objects
    //  */

    public function findByQuestion(int $questionId)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.question = :questionId')
            ->setParameter('questionId', $questionId)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getIsMultipleQuestion(int $questionId): bool
    {

        $this->logger->critical($questionId);
        $qb = $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->andWhere('a.question = :questionId')
            ->setParameter('questionId', $questionId)
            ->andWhere('a.is_correct = true');

        $this->logger->critical($qb);

        try {
            $numberOfCorrectAnswers = $qb->getQuery()->getSingleScalarResult();

            $this->logger->critical($numberOfCorrectAnswers);

            if($numberOfCorrectAnswers > 1){
                return true;
            } else {
                return false;
            }

        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }
    }


    /*
    public function findOneBySomeField($value): ?Answer
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
