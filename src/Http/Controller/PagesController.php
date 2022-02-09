<?php

namespace App\Http\Controller;

use App\Domain\Blog\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {

        $post = (new Post())->setCreatedAt(new \DateTime())
            ->setOnline(true)
            ->setTitle('tttttest')
            ->setContent('tttttttt')
            ->setSlug('3-3-3-3-3')
            ->setUpdatedAt(new \DateTime())
            ->setCategory('test');
        $this->em->persist($post);
        $this->em->flush();
        return $this->render('pages/home.html.twig');
    }
}
