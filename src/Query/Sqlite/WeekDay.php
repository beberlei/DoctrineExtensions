<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class WeekDay extends AbstractStrfTime
{
    protected function getFormat()
    {
        return '%w';
    }
}
