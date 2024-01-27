<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Tarjei Huse <tarjei.huse@gmail.com>
 */
class Date extends AbstractStrfTime
{
    protected function getFormat(): string
    {
        return '%Y-%m-%d';
    }
}
