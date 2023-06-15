<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Date
{
    #[ORM\Id]
    #[ORM\Column(type: 'string')]
    #[ORM\GeneratedValue]
    public string $id;

    #[ORM\Column(type: 'DateTime')]
    public \DateTime $created;
}
