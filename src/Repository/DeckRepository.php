<?php

namespace App\Repository;

use App\Entity\Deck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Deck|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deck|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deck[]    findAll()
 * @method Deck[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeckRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Deck::class);
    }

    public function findDecksForUser($user): array
    {
        $qb = $this->createQueryBuilder('d')
            ->join('d.user', 'u')
            ->where('u.id = :id')
            ->setParameters(['id' => $user->getId()])
            ->getQuery();

        return $qb->execute();
    }
}
