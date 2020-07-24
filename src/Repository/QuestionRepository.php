<?php

namespace App\Repository;

use App\Entity\Question;
use App\Entity\QuestionSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql\Rand;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    /**
     * @param QuestionSearch $search
     * @return Query
     */
    public function findAllQuery(QuestionSearch $search) : Query
    {
        $queryBuilder = $this->createQueryBuilder('q');

        if ($search->getLevelMin())
        {
            $queryBuilder = $queryBuilder
                ->where('q.level >= :levelMin')
                ->setParameter('levelMin', $search->getLevelMin());

        }

        return $queryBuilder->getQuery();
    }

    /**
     * @param int $nbOfQuestions
     * @return Query
     */
    public function findRandomResultsQuery(int $nbOfQuestions)
    {
        $qb = $this->createQueryBuilder('q');

        $qb = $qb->orderBy('RAND()');

        if ($nbOfQuestions){
            $qb->setMaxResults($nbOfQuestions);
        }

        //return $queryBuilder->getQuery();
        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $level
     * @return Question[]
     */
    public function findAllByLevel(int $level) : array
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.level = :level')
            ->setParameter('level', $level)
            ->orderBy('q.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Question[]
     */
    public function findLatest() : array
    {
        return $this->createQueryBuilder('q')
            ->setMaxResults(12)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Question[] Returns an array of Question objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Question
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
