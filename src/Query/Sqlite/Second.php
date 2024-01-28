<?php

namespace DoctrineExtensions\Query\Sqlite;

class Second extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%S';
    }
}
