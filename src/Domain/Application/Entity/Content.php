<?php

declare(strict_types=1);

namespace App\Domain\Application\Entity;

use App\Domain\Auth\Entity\User;
use App\Domain\Blog\Entity\Post;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'type', type: 'string')]
#[DiscriminatorMap([
    'post' => Post::class
])]

abstract class Content
{
    #[Id]
    #[GeneratedValue('IDENTITY')]
    #[Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[Column(type: Types::STRING, length: 255, nullable: true)]
    #[Length(min: 4)]
    #[NotBlank]
    private ?string $title = null;

    #[Column(type: Types::TEXT, length: 255, nullable: true)]
    #[Length(min: 6)]
    #[NotBlank]
    private ?string $content = null;

    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[Column(type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(nullable: true)]
    private ?User $author = null;

    #[Column(type: 'boolean')]
    private bool $online = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function isOnline(): bool
    {
        return $this->online;
    }


    public function setOnline(bool $online): self
    {
        $this->online = $online;
        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): Content
    {
        $this->author = $author;
        return $this;
    }
}
