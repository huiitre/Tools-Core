<?php

namespace App\Repository\Dofus;

use App\Entity\Dofus\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public $cnx_tools_core;
    public $cnx_tools_dofus;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
        $this->cnx_tools_core = $registry->getConnection('tools_core');
        $this->cnx_tools_dofus = $registry->getConnection('tools_dofus');
    }

    public function add(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Item $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function insertItem($list)
    {
        $sql = "
            INSERT INTO item (iditem, name, img, iditem_type, level, code) values (:iditem, :name, :img, :iditem_type, :level, :code)
        ";

        $cnx_tools_dofus = $this->cnx_tools_dofus;
        $cnx_tools_dofus->beginTransaction();

        $count = 0;
        $countArray = count($list);

        foreach($list as $item) {
            $query = $cnx_tools_dofus->prepare($sql);
            $query->bindValue('iditem', $item->getId(), PDO::PARAM_INT);
            $query->bindValue('name', $item->getName(), PDO::PARAM_STR);
            $query->bindValue('iditem_type', $item->getIditem_type(), PDO::PARAM_STR);
            $query->bindValue('level', $item->getLevel(), PDO::PARAM_STR);
            $query->bindValue('img', $item->getImg(), PDO::PARAM_STR);
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
//     * @return Item[] Returns an array of Item objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Item
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
