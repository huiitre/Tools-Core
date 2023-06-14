<?php

namespace App\Repository\Dofus;

use App\Entity\Dofus\ResourceType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @extends ServiceEntityRepository<ResourceType>
 *
 * @method ResourceType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResourceType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResourceType[]    findAll()
 * @method ResourceType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceTypeRepository extends ServiceEntityRepository
{
    public $cnx_tools_core;
    public $cnx_tools_dofus;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResourceType::class);
        $this->cnx_tools_core = $registry->getConnection('tools_core');
        $this->cnx_tools_dofus = $registry->getConnection('tools_dofus');
    }

    public function add(ResourceType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ResourceType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function insertResourceType($list)
    {
        $sql = "
            INSERT INTO resource_type (idresource_type, name, code) values (:idresource_type, :name, :code)
        ";

        $cnx_tools_dofus = $this->cnx_tools_dofus;
        $cnx_tools_dofus->beginTransaction();

        $count = 0;
        $countArray = count($list);

        foreach($list as $item) {
            $query = $cnx_tools_dofus->prepare($sql);
            $query->bindValue('idresource_type', $item->getIdresource_type(), PDO::PARAM_INT);
            $query->bindValue('name', $item->getName(), PDO::PARAM_STR);
            $query->bindValue('code', $item->getCode(), PDO::PARAM_STR);
            $ok = $query->executeStatement();
            if ($ok)
                $count++;
        }

        if ($countArray == $count) {
            $cnx_tools_dofus->commit();
            return 1;
        }
        $cnx_tools_dofus->rollBack();
        return 0;
    }

//    /**
//     * @return ResourceType[] Returns an array of ResourceType objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ResourceType
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
