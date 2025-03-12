<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\User;

use App\Domain\Security\Entity\User;
use App\Domain\Security\Interface\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends  ServiceEntityRepository<User>
 */
class DoctrineUserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $em = $this->getEntityManager();

        $em->persist($user);
        $em->flush();
    }

    public function isEmailExist(string $email): bool
    {
        $qb = $this->createQueryBuilder('u');

        $qb
            ->select('COUNT(u.id)')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
        ;

        return (bool) $qb->getQuery()->getSingleScalarResult();
    }

    public function findOneByEmailVerifyToken(string $token): ?User
    {
        $qb = $this->createQueryBuilder('u');

        $qb
            ->andWhere('u.emailVerificationToken = :token')
            ->setParameter('token', $token)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
