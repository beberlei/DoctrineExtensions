<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Einar Gangsø <mail@einargangso.no>
 */
class JulianDay extends AbstractStrfTime
{
    protected function getFormat()
    {
        return '%J';
    }
}
