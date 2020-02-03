<?php

namespace App\Repository;

use App\Entity\Folder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Folder|null find($id, $lockMode = null, $lockVersion = null)
 * @method Folder|null findOneBy(array $criteria, array $orderBy = null)
 * @method Folder[]    findAll()
 * @method Folder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FolderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Folder::class);
    }

    public function findByBand($id)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.band =' . $id)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findById($id, $bandId): ?Folder
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.band =' . $bandId)
            ->andWhere('f.id = ' . $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
