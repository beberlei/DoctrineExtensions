<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Dawid Nowak <macdada@mmg.pl>
 */
class Hour extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%H';
    }
}
