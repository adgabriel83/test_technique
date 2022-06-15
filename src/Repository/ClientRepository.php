<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function add(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Client[] Returns an array of Client objects
     */
    public function findByNbMaterielAndMontant(int $nbMateriel, int $montantMateriel): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.lienMateriel', 'lm')
            ->join('lm.materiel', 'm')
            ->groupBy('lm.client')
            ->having('SUM(lm.quantity) > :nbMateriel')
            ->andHaving('SUM(lm.quantity*m.price) > :montantMateriel')
            ->setParameters(['nbMateriel'=>$nbMateriel, 'montantMateriel'=> $montantMateriel*100])// On convertit le montant en centimes
            ->orderBy('SUM(lm.quantity*m.price)', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Client
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
