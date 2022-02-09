<?php

namespace App\Domain\Blog\Events;

use App\Domain\Blog\Entity\Post;

class DeletedPostEvent
{
    public function __construct(private post $post)
    {
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }
}
