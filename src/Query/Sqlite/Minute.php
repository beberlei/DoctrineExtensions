<?php

namespace DoctrineExtensions\Query\Sqlite;

class Minute extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%M';
    }
}
