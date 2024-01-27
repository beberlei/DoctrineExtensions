<?php

declare(strict_types=1);

namespace DoctrineExtensions\Tests\Entities;

/**
 * @Entity
 */
class Set
{
    /** @Id @Column(type="string") @GeneratedValue */
    public $id;

    /**
     * @Column(type="String")
     */
    public $set;
}
