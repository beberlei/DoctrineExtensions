<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Minute extends AbstractStrfTime
{
    protected function getFormat()
    {
        return '%M';
    }
}
