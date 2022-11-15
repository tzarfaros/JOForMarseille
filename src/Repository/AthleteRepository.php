<?php

namespace App\Repository;

use App\Entity\Athlete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Bool_;

/**
 * @extends ServiceEntityRepository<Athlete>
 *
 * @method Athlete|null find($id, $lockMode = null, $lockVersion = null)
 * @method Athlete|null findOneBy(array $criteria, array $orderBy = null)
 * @method Athlete[]    findAll()
 * @method Athlete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AthleteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Athlete::class);
    }

    public function save(Athlete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Athlete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Athlete
     */
    public function findAthletesByFilters(bool $gender = null , string $nationality = null , string $epreuves = null)
    {
        $entityManager = $this->getEntityManager();

        $dql = "SELECT a FROM App\Entity\Athlete a INNER JOIN a.epreuves e WHERE a.image == 'todo' ";

        if (isset($gender) && $gender) {
            $andGender= "AND a.gender = '$gender' ";
            $dql .= $andGender;
        }

        if (isset($nationality) && $nationality) {
            $andNationality= "AND a.nationality LIKE '%$nationality%' ";
            $dql .= $andNationality;
        }

        if (isset($epreuves) && $epreuves) {
            $andEpreuves= "AND e.name LIKE '%$epreuves%' ";
            $dql .= $andEpreuves;
        }

        $orderBy = "ORDER BY a.nationality DESC"; 
        $dql .= $orderBy;

        $query = $entityManager->createQuery($dql);

        return $query->getResult();
    }

//    /**
//     * @return Athlete[] Returns an array of Athlete objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Athlete
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
