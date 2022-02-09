<?php

namespace App\Domain\Blog\Repository;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface PostRepositoryInterface
{
    public function findPublic(): Query;

    public function findAdminIndex(): QueryBuilder;
}
