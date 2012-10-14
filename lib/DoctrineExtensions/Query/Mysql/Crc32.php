<?php

/*
 * DoctrineExtensions Mysql Function Pack
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to kontakt@beberlei.de so I can send you a copy immediately.
 */

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;

/**
 * "CRC32" "(" StringPrimary ")"
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Query\Mysql
 * @author      Igor Timoshenko <igor.timoshenko@i.ua>
 * @license     New BSD License
 */
class Crc32 extends FunctionNode
{
    public $stringPrimary;

    /**
     * @override
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'CRC32(' .
            $sqlWalker->walkStringPrimary($this->stringPrimary) .
        ')';
    }

    /**
     * @override
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
