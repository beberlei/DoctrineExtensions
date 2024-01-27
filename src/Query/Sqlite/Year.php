<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

class Year extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%Y';
    }
}
