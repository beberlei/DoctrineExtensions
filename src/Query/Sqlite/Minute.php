<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Minute extends NumberFromStrfTime
{
    protected function getFormat()
    {
        return '%M';
    }
}
