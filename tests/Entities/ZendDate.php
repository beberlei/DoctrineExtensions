<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class ZendDate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    public $id;

    /** @ORM\Column(type="ZendDate") */
    public $date;

    public function __construct($id, $date)
    {
        $this->id   = $id;
        $this->date = $date;
    }
}
