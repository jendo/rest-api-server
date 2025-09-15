<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

trait EntityIdTrait
{
    public const COLUMN_ID = 'id';

    #[ORM\Id]
    #[ORM\Column(name: self::COLUMN_ID, type: 'uuid', unique: true, nullable: false)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public static function getIdColumn(): string
    {
        return self::COLUMN_ID;
    }
}
