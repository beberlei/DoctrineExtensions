<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

class Day extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%d';
    }
}
