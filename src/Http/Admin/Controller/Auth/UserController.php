<?php

namespace App\Http\Admin\Controller\Auth;

use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Repository\UserRepository;
use App\Http\Admin\Controller\CrudController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users', name: 'user_')]
class UserController extends CrudController
{
    #[Route('/search', name: 'autocomplete')]
    public function search(Request $request): JsonResponse
    {
        /** @var UserRepository $repository */
        $repository = $this->em->getRepository(User::class);
        $q = strtolower($request->query->get('q') ?: '');
        if ('moi' === $q) {
            return new JsonResponse([[
                'id' => $this->getUser()->getId(),
                'username' => $this->getUser()->getUsername(),
            ]]);
        }
        $users = $repository
            ->createQueryBuilder('u')
            ->select('u.id', 'u.username')
            ->where('LOWER(u.username) LIKE :username')
            ->setParameter('username', "%$q%")
            ->setMaxResults(25)
            ->getQuery()
            ->getResult();

        return new JsonResponse($users);
    }
}
