<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\UserDetails;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use function PHPUnit\Framework\isNull;

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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
$temp=$this->findOneBy(['username' => $entity->getUsername()]);

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findAllWhoAreNotBlockAndDelete(): array
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.id, u.username, u.email, u.roles, ud.registerDate')
            ->leftJoin('u.UserDetails', 'ud')
            ->where('u.banned = :banned')
            ->andWhere('u.activate = :activate')
            ->setParameter('banned', false)
            ->setParameter('activate', true);

        return $qb->getQuery()->getArrayResult();
    }


    public function findOneByAllDetailsId(int $id): ?array
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.id as userId, u.username, u.email, u.roles, u.isVerified, u.activate, u.banned,ud')
            ->join(UserDetails::class, 'ud')
            ->where('u.id = :userId')
            ->andWhere('ud.id = u.UserDetails')
            ->setParameter('userId', $id);
        $result = $qb->getQuery()->getResult();
        $age = null;
        if (empty($result)) {
            throw new NotFoundHttpException('User not found.', null, 404);
        }
        if ($result[0][0]->getBirthDate() != null) {
            $today = new DateTime();
            $age = $today->diff($result[0][0]->getBirthDate())->y;
        }

        $data = [
            'user' => $result[0],
            'userDetails' => $result[0][0],
            'userAge' => $age
        ];

        return empty($result) ? null : $data;
    }

    public function remove(User $entity, bool $flush = false): void
    {

        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    #[NoReturn] private function updateRole(User $entity): void
    {


        $user = $this->findOneBy(['username' => $entity->getUsername()]);

        $user->setRoles(['']);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
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
    public function update(User $entity, bool $flush)
    {

        if($entity->getRoles()!=null){
            $this->updateRole($entity);
        }
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllWhoAreRemoved(): array
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.id, u.username, u.email, u.roles, u.banDate, u.ban_reason')
            ->where('u.banned = :banned')
            ->setParameter('banned', true);


        return $qb->getQuery()->getArrayResult();
    }

    public function findAllWhoAreBanned(): array
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u.id, u.username, u.email, u.roles, u.banDate, u.ban_reason')
            ->where('u.banned = :banned')
            ->setParameter('banned', true);


        return $qb->getQuery()->getArrayResult();
    }

}
