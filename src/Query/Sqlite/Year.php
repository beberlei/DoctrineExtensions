<?php

namespace DoctrineExtensions\Query\Sqlite;

class Year extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%Y';
    }
}
