<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table]
class ZendDate
{
    #[ORM\Id]
    #[ORM\Column]
    public int $id;

    #[ORM\Column(type: 'ZendDate')]
    public $date;

    public function __construct($id, $date)
    {
        $this->id = $id;
        $this->date = $date;
    }
}
