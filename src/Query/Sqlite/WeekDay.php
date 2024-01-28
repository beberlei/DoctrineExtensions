<?php

namespace DoctrineExtensions\Query\Sqlite;

class WeekDay extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%w';
    }
}
