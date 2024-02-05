<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Set
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue
     */
    public $id;

    /** @ORM\Column(type="String") */
    public $set;
}
