<?php

namespace App\Http\Admin\Data;

use App\Domain\Auth\Entity\User;
use App\Domain\Blog\Entity\Post;
use App\Http\Form\AutomaticForm;

class BlogCrudData implements CrudDataInterface
{
    public ?string $title;

    public ?string $content;

    public ?\DateTimeInterface $createdAt;

    public ?\DateTimeInterface $updatedAt;

    //public ?User $author;

    public bool $online;

    private Post $entity;

    public function __construct(Post $data)
    {
        $this->entity = $data;
        $this->title = $data->getTitle();
        $this->content = $data->getContent();
        $this->createdAt = $data->getCreatedAt();
        $this->updatedAt = $data->getUpdatedAt();
        $this->online = $data->isOnline();
    }

    public function getEntity(): Post
    {
        return $this->entity;
    }

    public function getFormClass(): string
    {
        return AutomaticForm::class;
    }

    public function hydrate(): void
    {
        $this->entity->setTitle($this->title);
        $this->entity->setContent($this->content);
        $this->entity->setOnline($this->online);
        $this->entity->setCreatedAt($this->createdAt);
    }
}
