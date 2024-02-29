<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
#[ORM\Entity]
class BlogPost
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue
     */
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    #[ORM\GeneratedValue]
    public $id;

    /** @ORM\Column(type="datetime") */
    #[ORM\Column(type: 'datetime')]
    public $created;

    /** @ORM\Column(type="decimal", precision=12, scale=8) */
    #[ORM\Column(type: 'decimal', precision: 12, scale: 8)]
    public $longitude;

    /** @ORM\Column(type="decimal", precision=12, scale=8) */
    #[ORM\Column(type: 'decimal', precision: 12, scale: 8)]
    public $latitude;
}
