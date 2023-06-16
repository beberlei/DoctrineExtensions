<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class BlogPost
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue]
    public $id;

    #[ORM\Column]
    public \DateTime $created;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 8)]
    public $longitude;

    #[ORM\Column(type: 'decimal', precision: 12, scale: 8)]
    public $latitude;
}
