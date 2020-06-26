<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class WeekDay extends NumberFromStrfTime
{
    protected function getFormat()
    {
        return '%w';
    }
}
