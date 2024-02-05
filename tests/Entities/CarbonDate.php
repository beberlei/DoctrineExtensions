<?php

namespace DoctrineExtensions\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class CarbonDate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    public $id;

    /** @ORM\Column(type="CarbonDate", nullable=true) */
    public $date;

    /** @ORM\Column(type="CarbonDateTime", nullable=true) */
    public $datetime;

    /** @ORM\Column(type="CarbonDateTimeTz", nullable=true) */
    public $datetimeTz;

    /** @ORM\Column(type="CarbonTime", nullable=true) */
    public $time;

    /** @ORM\Column(type="CarbonImmutableDate", nullable=true) */
    public $dateImmutable;

    /** @ORM\Column(type="CarbonImmutableDateTime", nullable=true) */
    public $datetimeImmutable;

    /** @ORM\Column(type="CarbonImmutableDateTimeTz", nullable=true) */
    public $datetimeTzImmutable;

    /** @ORM\Column(type="CarbonImmutableTime", nullable=true) */
    public $timeImmutable;
}
