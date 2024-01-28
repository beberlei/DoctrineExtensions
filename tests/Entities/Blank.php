<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Entities;

/** @Entity */
class Blank
{
    /**
     * @Id
     * @Column(type="string")
     * @GeneratedValue
     */
    public $id;
}
