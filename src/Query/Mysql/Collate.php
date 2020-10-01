<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

/**
 * @link https://dev.mysql.com/doc/refman/en/charset-collate.html
 * @author Peter Tanath <peter.tanath@gmail.com>
 */
class Collate extends FunctionNode
{
    /**
     * @var null
     */
    public $stringPrimary = null;

    /**
     * @var null
     */
    public $collation = null;

    /**
     * @param \Doctrine\ORM\Query\Parser $parser
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

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
        return sprintf('%s COLLATE %s', $sqlWalker->walkStringPrimary($this->stringPrimary), $this->collation);
    }
}
