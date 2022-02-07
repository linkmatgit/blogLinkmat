<?php

namespace App\Infrastructure\Helper\Paginator;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PageOutOfBoundException extends BadRequestHttpException
{
}
