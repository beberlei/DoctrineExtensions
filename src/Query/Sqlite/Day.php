<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Rafael Kassner <kassner@gmail.com>
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
class Day extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%d';
    }
}
