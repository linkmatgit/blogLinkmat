<?php

namespace App\Domain\Blog\Repository;

use App\Domain\Blog\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function findPublic(): Query
    {
        return $this->createQueryBuilder('p')
            ->where('p.online = true')
            ->getQuery()
            ->getResult();
    }

    public function findAdminIndex(): Query
    {
        return  $this->createQueryBuilder('p')
           ->getQuery()
           ;
    }
}
