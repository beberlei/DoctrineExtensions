<?php

namespace DoctrineExtensions\Query\Sqlite;

class Date extends AbstractStrfTime
{
    protected function getFormat(): string
    {
        return '%Y-%m-%d';
    }
}
