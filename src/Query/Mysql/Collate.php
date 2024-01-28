<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

use function sprintf;

/**
 * @link https://dev.mysql.com/doc/refman/en/charset-collate.html
 *
 * @author Peter Tanath <peter.tanath@gmail.com>
 */
class Collate extends FunctionNode
{
    /** @var null */
    public $stringPrimary = null;

    /** @var null */
    public $collation = null;

    public function parse(Parser $parser): void
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(Lexer::T_COMMA);
        $parser->match(Lexer::T_IDENTIFIER);

        $lexer = $parser->getLexer();

        $this->collation = $lexer->token->value;

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf('%s COLLATE %s', $sqlWalker->walkStringPrimary($this->stringPrimary), $this->collation);
    }
}
