<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Steve Lacey <steve@stevelacey.net>
 */
class Date extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%Y-%m-%d';
    }
}
