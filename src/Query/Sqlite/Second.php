<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

class Second extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%S';
    }
}
