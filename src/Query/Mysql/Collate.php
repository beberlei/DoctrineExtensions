<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * "COLLATE"
 * override the default collation
 * More info:
 * https://dev.mysql.com/doc/refman/5.7/en/charset-collate.html
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Query\Mysql
 * @author      Peter Tanath <peter.tanath@gmail.com>
 * @license     MIT License
 */
class Collate extends FunctionNode
{

    /**
     * @var null
     */
    protected $expressionToCollate = null;

    /**
     * @var null
     */
    protected $collation = null;


    /**
     * @param \Doctrine\ORM\Query\Parser $parser
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->expressionToCollate = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);

        $parser->match(Lexer::T_IDENTIFIER);
        $lexer = $parser->getLexer();
        $this->collation = $lexer->token['value'];

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf( '%s COLLATE %s', $this->expressionToCollate->dispatch($sqlWalker), $this->collation );
    }
}