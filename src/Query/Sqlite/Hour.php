<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Hour extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%H';
    }
}
