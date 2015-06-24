<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Rafael Kassner <kassner@gmail.com>
 */
class Year extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%Y';
    }
}
