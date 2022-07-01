<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Day extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%d';
    }
}
