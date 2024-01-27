<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

class Hour extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%H';
    }
}
