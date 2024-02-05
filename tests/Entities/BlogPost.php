<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class BlogPost
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="DateTime") */
    public $created;

    /** @ORM\Column(type="decimal", precision=12, scale=8) */
    public $longitude;

    /** @ORM\Column(type="decimal", precision=12, scale=8) */
    public $latitude;
}
