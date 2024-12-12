<?php

namespace App\Infrastructure\NBP;

use App\Domain\Entity\Currency\Currency;
use App\Domain\Interface\NBP\DoctrineCurrencyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class Repository extends ServiceEntityRepository implements DoctrineCurrencyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    public function save(Currency $currency): void
    {
        $em = $this->getEntityManager();

        $em->persist($currency);
        $em->flush();
    }

    public function findOneByCode(string $code): ?Currency
    {
        return $this->findOneBy(['code' => $code]);
    }
}
