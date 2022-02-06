<?php

namespace App\Http\Controller\Users;

use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Event\UserConfirmedEvent;
use App\Domain\Auth\Event\UserCreatedEvent;
use App\Domain\Auth\Services\FormServiceInterface;
use App\Http\Controller\AbstractController;
use App\Http\Form\RegisterFormType;
use App\Infrastructure\Security\TokenGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
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
        private UserPasswordHasherInterface $hasher,
        private EntityManagerInterface $em,
        private TokenGeneratorInterface $generator,
    ) {
    }

    #[Route('/inscription', name: 'app_register')]
    public function register(): Response
    {

        $loggedUser = $this->getUser();
        if ($loggedUser) {
            return $this->redirectToRoute('app_home');
        }
        $user = new User();
        $rootError = [];
        $form = $this->createForm(RegisterFormType::class, $user);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $this->hasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $this->service->proceed($this->em, $user, $this->generator);
            $this->addFlash(
                'success',
                'Un message avec un lien de confirmation vous a été envoyé par mail. 
                Veuillez suivre ce lien pour activer votre compte.'
            );
            $this->dispatcher->dispatch(new UserCreatedEvent($user));

            return $this->redirectToRoute('app_register');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'menu' => 'register',
            'errors' => $rootError,
        ]);
    }

    #[Route('inscription/confirmation_token/[id<\d+>]', name: 'app_confirm_token')]
    public function confirmToken(User $user, Request $request): RedirectResponse
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
        $this->service->confirmToken($this->em, $user);
        $this->dispatcher->dispatch(new UserConfirmedEvent($user));
        $this->addFlash('success', 'Votre compte a été validé.');

        return $this->redirectToRoute('app_home');
    }
}
