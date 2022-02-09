<?php

namespace App\Domain\Blog\Repository;

use Doctrine\ORM\Query;

interface PostRepositoryInterface
{
    public function findPublic(): Query;

    public function findAdminIndex(): Query;
}
