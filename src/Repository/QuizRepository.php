<?php

namespace App\Repository;

use App\Entity\Quiz;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quiz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quiz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quiz[]    findAll()
 * @method Quiz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuizRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quiz::class);
    }

    public function findByUser(int $userId, bool $runningOnly = false) : array
    {
        $qb = $this->createQueryBuilder('q')
            ->andWhere('q.user = :userId')
            ->setParameter('userId', $userId);

        if ($runningOnly){
            $qb->andWhere('q.is_running = true')
                ->setMaxResults(1);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }

    public function getMaxNumber(int $userId) : ?int
    {
        $qb = $this->createQueryBuilder('q')
            ->select('MAX(q.number)')
            ->andWhere('q.user = :userId')
            ->setParameter('userId', $userId);

        try {
            return $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }
    }

    /**
     * Return an array with the number of gold, silver and bronze trophies
     *
     * @param int $userId
     * @return array
     *
     */
    public function getTrophies(int $userId)
    {
        $trophies = array();

        $qb = $this->createQueryBuilder('q')
            ->select('COUNT(q.id)')
            ->andWhere('q.user = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('q.score = 10');

        try {
            $trophies['gold'] = $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        $qb = $this->createQueryBuilder('q')
            ->select('COUNT(q.id)')
            ->andWhere('q.user = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('q.score IN (8,9)');

        try {
            $trophies['silver'] = $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        $qb = $this->createQueryBuilder('q')
            ->select('COUNT(q.id)')
            ->andWhere('q.user = :userId')
            ->setParameter('userId', $userId)
            ->andWhere('q.score IN (6,7)');

        try {
            $trophies['bronze'] = $qb->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
        } catch (NonUniqueResultException $e) {
        }

        return $trophies;
    }

    // /**
    //  * @return Quiz[] Returns an array of Quiz objects
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
    public function findOneBySomeField($value): ?Quiz
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
