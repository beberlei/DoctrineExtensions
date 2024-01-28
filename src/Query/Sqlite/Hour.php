<?php

namespace DoctrineExtensions\Query\Sqlite;

class Hour extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%H';
    }
}
