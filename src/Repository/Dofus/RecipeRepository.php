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
class RecipeRepository extends ServiceEntityRepository
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

    public function getRecette($identity, $iduser)
    {
        $sql = "
            select
                coalesce(i.id, r.id) AS id,
                coalesce(i.name, r.name) AS name,
                coalesce(i.img, r.img) AS img,
                rc.quantity,
                p.unit_price
            FROM recette rc
            LEFT JOIN item i ON rc.idenfant = i.id
            LEFT JOIN resource r ON rc.idenfant = r.id
            left join price p on (p.identity = coalesce(i.id, r.id) and p.iduser = 1)
            WHERE rc.idparent = :id
        ";
    }

    public function insertRecette($list)
    {
        $sql = "
            INSERT INTO recette (idrecipe, idparent, idenfant, quantity) values (:idrecipe, :idparent, :idenfant, :quantity)
        ";

        $cnx_tools_dofus = $this->cnx_tools_dofus;
        $cnx_tools_dofus->beginTransaction();

        $count = 0;
        $countArray = count($list);

        foreach($list as $item) {
            $query = $cnx_tools_dofus->prepare($sql);
            $query->bindValue('idrecipe', $item->getIdRecipe(), PDO::PARAM_INT);
            $query->bindValue('idparent', $item->getIdParent(), PDO::PARAM_INT);
            $query->bindValue('idenfant', $item->getIdEnfant(), PDO::PARAM_INT);
            $query->bindValue('quantity', $item->getQuantity(), PDO::PARAM_INT);
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
