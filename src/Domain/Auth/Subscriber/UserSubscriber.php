<?php

namespace App\Domain\Auth\Subscriber;

use App\Domain\Auth\Event\UserCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    public function onRegister($event): void
    {
        return;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserCreatedEvent::class => 'onRegister',
        ];
    }
}
