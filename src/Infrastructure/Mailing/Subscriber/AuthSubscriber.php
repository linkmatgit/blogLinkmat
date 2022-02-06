<?php

namespace App\Infrastructure\Mailing\Subscriber;

use App\Domain\Auth\Event\UserCreatedEvent;
use App\Infrastructure\Mailing\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuthSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly Mailer $mailer)
    {
    }

    /**
     * @return array<string,string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'onRegister',
        ];
    }

    public function onRegister(UserCreatedEvent $event): void
    {
        $email = $this->mailer->createEmail('mails/auth/register.twig', [
            'user' => $event->getUser(),
        ])
            ->to($event->getUser()->getEmail())
            ->subject('Linkmat | Confirmation du compte');
        $this->mailer->send($email);
    }
}
