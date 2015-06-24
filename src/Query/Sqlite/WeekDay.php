<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Pavlo Cherniavskyi <ionafan2@gmail.com>
 */
class WeekDay extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%w';
    }
}
