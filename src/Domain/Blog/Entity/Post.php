<?php

namespace App\Domain\Blog\Entity;

use App\Domain\Application\Entity\Content;
use App\Domain\Blog\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table('blog_post')]
class Post extends Content
{
    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $category = null;

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return Post
     */
    public function setCategory(?string $category): Post
    {
        $this->category = $category;
        return $this;
    }
}
