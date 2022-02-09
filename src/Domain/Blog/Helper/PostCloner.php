<?php

namespace App\Domain\Blog\Helper;

use App\Domain\Blog\Entity\Post;
use App\Http\Admin\Cloner\CloneInterface;

class PostCloner implements CloneInterface
{

    public function clone(object $rows): object
    {
        $clone = new Post();
        $clone->setTitle($rows->getTitle());
        $clone->setSlug($rows->getSlug());
        $clone->setAuthor($rows->getAuthor());
        $clone->setOnline($rows->isOnline());
        $clone->setContent($rows->getContent());
        //$clone->setCategory($rows->getCategory());
        $clone->setCreatedAt(new \DateTime());
        return $clone;
    }
}