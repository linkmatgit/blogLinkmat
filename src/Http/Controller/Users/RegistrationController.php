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
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    #[Route('/inscription/confirmation/{id<\d+>}', name: 'register_confirm')]
    public function confirmToken(User $user, Request $request, EntityManagerInterface $em): RedirectResponse
    {
        $token = $request->get('token');
        if (empty($token) || $token !== $user->getConfirmationToken()) {
            $this->addFlash('error', "Ce token n'est pas valide");

            return $this->redirectToRoute('app_register');
        }

        if ($user->getRegisterAt() < new \DateTime('-2 hours')) {
            $this->addFlash('error', 'Ce token a expiré');

            return $this->redirectToRoute('app_register');
        }
        $user->setConfirmationToken(null);
        $em->flush();
        $this->addFlash('success', 'Votre compte a été validé.');

        return $this->redirectToRoute('app_login');
    }
}
