<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
final class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    #[ORM\GeneratedValue]
    public string $id;

    #[ORM\Column]
    public string $name;

    #[ORM\Column]
    public \DateTime $created;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    public $price;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    public $weight;
}
