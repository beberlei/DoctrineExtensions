<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

class JulianDay extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%J';
    }
}
