<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Date extends AbstractStrfTime
{
    protected function getFormat()
    {
        return '%Y-%m-%d';
    }
}
