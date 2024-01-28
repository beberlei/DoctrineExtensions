<?php

namespace DoctrineExtensions\Query\Sqlite;

/** @author Tarjei Huse <tarjei.huse@gmail.com> */
class Month extends NumberFromStrfTime
{
    protected function getFormat(): string
    {
        return '%m';
    }
}
