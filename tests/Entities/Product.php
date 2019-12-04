<?php

namespace DoctrineExtensions\Tests\Entities;

/**
 * @Entity
 */
class Product
{
    /** @Id @Column(type="string") @GeneratedValue */
    public $id;

    /**
     * @Column(type="string")
     */
    public $name;

    /**
     * @Column(type="DateTime")
     */
    public $created;

    /**
     * @Column(type="decimal", precision=10, scale=2)
     */
    public $price;

    /**
     * @Column(type="decimal", precision=5, scale=2)
     */
    public $weight;
}
