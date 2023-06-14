<?php

namespace App\Repository\Dofus;

use App\Entity\Dofus\Resource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @extends ServiceEntityRepository<Resource>
 *
 * @method Resource|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resource|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resource[]    findAll()
 * @method Resource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResourceRepository extends ServiceEntityRepository
{
    
    public $cnx_tools_core;
    public $cnx_tools_dofus;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resource::class);
        $this->cnx_tools_core = $registry->getConnection('tools_core');
        $this->cnx_tools_dofus = $registry->getConnection('tools_dofus');
    }

    public function add(Resource $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Resource $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function insertResource($list)
    {
        $sql = "
            INSERT INTO resource (idresource, name, img, qty_bank, idresource_type, code) values (:idresource, :name, :img, :qty_bank, :idresource_type, :code)
        ";

        $cnx_tools_dofus = $this->cnx_tools_dofus;
        $cnx_tools_dofus->beginTransaction();

        $count = 0;
        $countArray = count($list);

        foreach($list as $item) {
            $query = $cnx_tools_dofus->prepare($sql);
            $query->bindValue('idresource', $item->getIdResource(), PDO::PARAM_INT);
            $query->bindValue('name', $item->getName(), PDO::PARAM_STR);
            $query->bindValue('idresourceType', $item->getIdresource_type(), PDO::PARAM_STR);
            $query->bindValue('img', $item->getImg(), PDO::PARAM_STR);
            $query->bindValue('qty_bank', $item->getQty_bank(), PDO::PARAM_INT);
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
//     * @return Resource[] Returns an array of Resource objects
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

//    public function findOneBySomeField($value): ?Resource
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
