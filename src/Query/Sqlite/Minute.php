<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Martin Štekl <martin.stekl@gmail.com>
 */
class Minute extends AbstractStrfTime
{
    protected function getFormat()
    {
        return '%M';
    }
}
