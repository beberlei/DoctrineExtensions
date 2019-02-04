<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Day extends AbstractStrfTime
{
    protected function getFormat()
    {
        return '%d';
    }
}
