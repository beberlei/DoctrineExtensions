<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
#[ORM\Entity]
class Product
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

    /** @ORM\Column(type="string") */
    #[ORM\Column(type: 'string')]
    public $name;

    /** @ORM\Column(type="DateTime") */
    #[ORM\Column(type: 'DateTime')]
    public $created;

    /** @ORM\Column(type="decimal", precision=10, scale=2) */
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    public $price;

    /** @ORM\Column(type="decimal", precision=5, scale=2) */
    #[ORM\Column(type: 'decimal', precision: 5, scale: 2)]
    public $weight;
}
