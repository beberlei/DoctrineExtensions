<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
#[ORM\Entity]
class CarbonDate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    public $id;

    /** @ORM\Column(type="CarbonDate", nullable=true) */
    #[ORM\Column(type: 'CarbonDate', nullable: true)]
    public $date;

    /** @ORM\Column(type="CarbonDateTime", nullable=true) */
    #[ORM\Column(type: 'CarbonDateTime', nullable: true)]
    public $datetime;

    /** @ORM\Column(type="CarbonDateTimeTz", nullable=true) */
    #[ORM\Column(type: 'CarbonDateTimeTz', nullable: true)]
    public $datetimeTz;

    /** @ORM\Column(type="CarbonTime", nullable=true) */
    #[ORM\Column(type: 'CarbonTime', nullable: true)]
    public $time;

    /** @ORM\Column(type="CarbonImmutableDate", nullable=true) */
    #[ORM\Column(type: 'CarbonImmutableDate', nullable: true)]
    public $dateImmutable;

    /** @ORM\Column(type="CarbonImmutableDateTime", nullable=true) */
    #[ORM\Column(type: 'CarbonImmutableDateTime', nullable: true)]
    public $datetimeImmutable;

    /** @ORM\Column(type="CarbonImmutableDateTimeTz", nullable=true) */
    #[ORM\Column(type: 'CarbonImmutableDateTimeTz', nullable: true)]
    public $datetimeTzImmutable;

    /** @ORM\Column(type="CarbonImmutableTime", nullable=true) */
    #[ORM\Column(type: 'CarbonImmutableTime', nullable: true)]
    public $timeImmutable;
}
