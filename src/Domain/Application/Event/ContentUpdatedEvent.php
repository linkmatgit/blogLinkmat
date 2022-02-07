<?php

namespace App\Domain\Application\Event;

use App\Domain\Application\Entity\Content;
use Symfony\Contracts\EventDispatcher\Event;

class ContentUpdatedEvent extends Event
{
    public function __construct(private Content $content)
    {
    }
    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }
}
