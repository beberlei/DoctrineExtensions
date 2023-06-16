<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table]
final class CarbonDate
{
    #[ORM\Id]
    #[ORM\Column]
    public int $id;

    #[ORM\Column(type: 'CarbonDate', nullable: true)]
    public $date;

    #[ORM\Column(type: 'CarbonDateTime', nullable: true)]
    public $datetime;

    #[ORM\Column(type: 'CarbonDateTimeTz', nullable: true)]
    public $datetime_tz;

    #[ORM\Column(type: 'CarbonTime', nullable: true)]
    public $time;

    #[ORM\Column(type: 'CarbonImmutableDate', nullable: true)]
    public $date_immutable;

    #[ORM\Column(type: 'CarbonImmutableDateTime', nullable: true)]
    public $datetime_immutable;

    #[ORM\Column(type: 'CarbonImmutableDateTimeTz', nullable: true)]
    public $datetime_tz_immutable;

    #[ORM\Column(type: 'CarbonImmutableTime', nullable: true)]
    public $time_immutable;
}
