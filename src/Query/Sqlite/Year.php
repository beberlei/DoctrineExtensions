<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Year extends AbstractStrfTime
{
    protected function getFormat()
    {
        return '%Y';
    }
}
