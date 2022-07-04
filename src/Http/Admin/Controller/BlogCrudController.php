<?php

namespace App\Http\Admin\Controller;

use App\Domain\Blog\Entity\Post;
use App\Domain\Blog\Events\CreatedPostEvent;
use App\Domain\Blog\Events\DeletedPostEvent;
use App\Domain\Blog\Events\UpdatedPostEvent;
use App\Domain\Blog\Repository\PostRepositoryInterface;
use App\Http\Admin\Cloner\CloneInterface;
use App\Http\Admin\Data\BlogCrudData;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/blog', name: 'blog_')]
class BlogCrudController extends CrudController
{
    /**
     * @var class-string<E>
     */
    protected string $entity = Post::class ;
    protected string $templatePath = 'blog';
    protected string $menuItem = 'blog';
    protected string $routePrefix = 'blog';
    protected string $searchField = 'title';
    protected array $events = [
        'update' => UpdatedPostEvent::class,
        'delete' => DeletedPostEvent::class,
        'create' => CreatedPostEvent::class,
    ];

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(PostRepositoryInterface $repository): Response
    {
        $query = $repository->findAdminIndex();
        return $this->crudIndex($query);
    }

    #[Route('/new', name: 'new', methods: ['POST', 'GET'])]
    public function new(): Response
    {
        $post = (new Post())
            ->setAuthor($this->getUser())
            ->setCreatedAt(new \DateTime());
        $data = new BlogCrudData($post);
        return $this->crudNew($data);
    }
    #[Route('/{id<\d+>}', name: 'edit')]
    public function edit(Post $row): Response
    {
        $data = (new BlogCrudData($row));

        return $this->crudEdit($data);
    }
    #[Route('/{id<\d+>}', name: 'delete', methods: ['DELETE'])]
    public function delete(Post $row): Response
    {
        return $this->crudDelete($row);
    }

    #[Route('/clone/{id<\d+>}', name: 'clone', methods: ['POST', 'GET'])]
    public function clone(CloneInterface $clone, Post $row): Response
    {
        $clone = $clone->clone($row);
        $data = new BlogCrudData($clone);
        return $this->crudNew($data);
    }
}
