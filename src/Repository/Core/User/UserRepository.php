<?php

namespace App\Repository\Core\User;

use App\Entity\Core\User\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public $tools_core;

    public $tools_test;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
        $this->tools_core = $registry->getConnection();
        $this->tools_test = $registry->getConnection('tools_test');
    }

    public function multipleDatabase()
    {
        $query1 = $this->tools_core->prepare('select * from user');
        $data = [...$query1->executeQuery()->fetchAllAssociative()];
        
        $query2 = $this->tools_test->prepare('select * from user');
        $data = [...$data, ...$query2->executeQuery()->fetchAllAssociative()];

        return $data;
    }

    public function createUser($user)
    {
        $tools_core = $this->tools_core;

        $sql = "
            CALL CreateUser(
                :email,
                :nickname,
                :password,
                :isActive,
                :type,
                :roles
            )
        ";
        $params = [
            'email' => $user->getEmail(),
            'nickname' => $user->getNickname(),
            'password' => $user->getpassword(),
            'isActive' => $user->getIs_active(),
            'type' => $user->getType(),
            'roles' => json_encode($user->getRoles())
        ];

        $query = $tools_core->prepare($sql);
        $result = $query->executeStatement($params);

        return $result;
    }

    public function findUserBy($array)
    {
        $tools_core = $this->tools_core;

        $sql = "
            select count(u.iduser)
            from user u
            where 
        ";

        if (count($array) === 1) {
            $key = key($array);
            $value = $array[$key];
            $sql .= "$key = '$value'";
        } else {
            $conditions = [];
            foreach ($array as $key => $value)
                $conditions[] = "$key = '$value'";

            $sql .= implode(' OR ', $conditions);
        }

        $query = $tools_core->prepare($sql);

        $result = $query->executeQuery()->fetchOne();

        return $result;
    }

    /* public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    } */

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
