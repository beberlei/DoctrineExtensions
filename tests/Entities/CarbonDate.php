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

    /**
     * @Column(type="CarbonDate", nullable=true)
     */
    public $date;

    /**
     * @Column(type="CarbonDateTime", nullable=true)
     */
    public $datetime;

    /**
     * @Column(type="CarbonDateTimeTz", nullable=true)
     */
    public $datetime_tz;

    /**
     * @Column(type="CarbonTime", nullable=true)
     */
    public $time;
}
