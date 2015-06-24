<?php

namespace DoctrineExtensions\Query\Sqlite;

/**
 * @author Rafael Kassner <kassner@gmail.com>
 * @author Sarjono Mukti Aji <me@simukti.net>
 */
class Month extends AbstractStrfTime
{

    protected function getFormat()
    {
        return '%m';
    }
}
