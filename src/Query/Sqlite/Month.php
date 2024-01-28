<?php

namespace DoctrineExtensions\Query\Sqlite;

class Month extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%m';
    }
}
