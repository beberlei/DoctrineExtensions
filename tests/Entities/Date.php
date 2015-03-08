<?php

namespace Entities;

/**
 * @Entity
 * @Table(name="dates")
 */
class Date
{
    /**
     * @Id
     * @Column(type="integer")
     */
    public $id;

    /**
     * @Column(type="zenddate")
     */
    public $date;

    public function __construct($id, $date)
    {
        $this->id = $id;
        $this->date = $date;
    }
}
