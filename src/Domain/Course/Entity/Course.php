<?php

namespace App\Domain\Course\Entity;

use App\Domain\Application\Entity\Content;
use App\Domain\Course\Repository\CourseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course extends Content
{

}
