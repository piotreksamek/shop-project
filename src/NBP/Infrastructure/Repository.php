<?php

namespace App\NBP\Infrastructure;

use App\NBP\Domain\Entity\Currency\Currency;
use App\NBP\Domain\Interface\CurrencyRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class Repository extends ServiceEntityRepository implements CurrencyRepositoryInterface
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
