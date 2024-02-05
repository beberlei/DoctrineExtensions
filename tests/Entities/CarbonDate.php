<?php

namespace DoctrineExtensions\Tests\Entities;

/**
 * @Entity
 * @Table
 */
class CarbonDate
{
    /**
     * @Id
     * @Column(type="integer")
     */
    public $id;

    /** @Column(type="CarbonDate", nullable=true) */
    public $date;

    /** @Column(type="CarbonDateTime", nullable=true) */
    public $datetime;

    /** @Column(type="CarbonDateTimeTz", nullable=true) */
    public $datetimeTz;

    /** @Column(type="CarbonTime", nullable=true) */
    public $time;

    /** @Column(type="CarbonImmutableDate", nullable=true) */
    public $dateImmutable;

    /** @Column(type="CarbonImmutableDateTime", nullable=true) */
    public $datetimeImmutable;

    /** @Column(type="CarbonImmutableDateTimeTz", nullable=true) */
    public $datetimeTzImmutable;

    /** @Column(type="CarbonImmutableTime", nullable=true) */
    public $timeImmutable;
}
