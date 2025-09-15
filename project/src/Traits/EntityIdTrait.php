<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

trait EntityIdTrait
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
