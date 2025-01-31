<?php

namespace App\Infrastructure\NBP;

use App\Domain\NBP\Entity\Currency\Currency;
use App\Domain\NBP\Interface\CurrencyRepositoryInterface;
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
