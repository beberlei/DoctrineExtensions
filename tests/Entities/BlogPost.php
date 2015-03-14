<?php

namespace DoctrineExtensions\Tests\Entities;

/**
 * @Entity
 */
class BlogPost
{
    /** @Id @Column(type="string") @GeneratedValue */
    public $id;

    /**
     * @Column(type="DateTime")
     */
    public $created;

    /**
     * @Column(type="decimal", precision=12, scale=8)
     */
    public $longitude;

    /**
     * @Column(type="decimal", precision=12, scale=8)
     */
    public $latitude;
}
