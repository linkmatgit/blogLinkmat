<?php

namespace App\Http\Controller\Users;

use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Event\UserCreatedEvent;
use App\Domain\Auth\Services\FormServiceInterface;
use App\Http\Form\RegisterFormType;
use App\Infrastructure\Security\TokenGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private FormServiceInterface $service,
        private EventDispatcherInterface $dispatcher,
        private EntityManagerInterface $em,
        private TokenGeneratorInterface $generator
    ) {
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
    ): Response {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $this->service->proceed($this->em, $user, $this->generator);
            // do anything else you need here, like send an email
            $this->dispatcher->dispatch(new UserCreatedEvent($user));
            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
