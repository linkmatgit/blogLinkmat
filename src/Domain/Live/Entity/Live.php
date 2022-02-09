<?php

namespace App\Domain\Live\Entity;

use App\Domain\Application\Entity\Content;
use App\Domain\Live\Repository\LiveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LiveRepository::class)]
final class Live extends Content
{
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $videoId = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $playlistId = null;


    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }

    public function getPlaylistId(): ?string
    {
        return $this->playlistId;
    }

    public function setPlaylistId(?string $playlistId): self
    {
        $this->playlistId = $playlistId;

        return $this;
    }
}
