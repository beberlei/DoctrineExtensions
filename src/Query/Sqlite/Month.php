<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Month extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%m';
    }
}
