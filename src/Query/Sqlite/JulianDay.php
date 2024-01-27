<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Einar Gangsø <mail@einargangso.no>
 */
class JulianDay extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%J';
    }
}
