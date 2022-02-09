<?php

namespace App\Http\Admin\Controller;

use App\Domain\Blog\Entity\Post;
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
    protected string $menuItem = '';
    protected string $routePrefix = 'blog';
    protected string $searchField = 'title';
    protected array $events = [
        'update' => null,
        'delete' => null,
        'create' => null,
    ];

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $this->paginator->allowSort('row.id');
        $query = $this->getRepository()
            ->createQueryBuilder('row')
            ->orderby('row.createdAt', 'DESC');
        return $this->crudIndex($query);
    }

    public function new(): Response
    {
        $post = (new Post())->setAuthor($this->getUser())->setCreatedAt(new \DateTime());
        $data = new BlogCrudData($post);
        return $this->crudNew($data);
    }


}
