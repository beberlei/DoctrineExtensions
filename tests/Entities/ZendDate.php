<?php

namespace DoctrineExtensions\Tests\Entities;

/**
 * @Entity
 * @Table
 */
class ZendDate
{
    /**
     * @Id
     * @Column(type="integer")
     */
    public $id;

    /**
     * @Column(type="ZendDate")
     */
    public $date;

    public function __construct($id, $date)
    {
        $this->id = $id;
        $this->date = $date;
    }
}
