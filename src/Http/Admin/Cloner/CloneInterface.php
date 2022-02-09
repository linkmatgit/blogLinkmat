<?php

namespace App\Http\Admin\Cloner;

interface CloneInterface
{
    public function clone(object $rows): object;
}