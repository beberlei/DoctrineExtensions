<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function sprintf;

/**
 * CollateFunction ::= "COLLATE" "(" StringPrimary "," Identifier ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/charset-collate.html
 *
 * @author Peter Tanath <peter.tanath@gmail.com>
 *
 * @example SELECT COLLATE("string", latin1_german2_ci)
 * @example SELECT COLLATE(foo.bar, latin1_german2_ci) FROM entity
 */
class Collate extends FunctionNode
{
    /** @var Node|null */
    public $stringPrimary = null;

    /** @var string|null */
    public $collation = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $this->stringPrimary = $parser->StringPrimary();

        $parser->match(TokenType::T_COMMA);
        $parser->match(TokenType::T_IDENTIFIER);

        $lexer = $parser->getLexer();

        $this->collation = $lexer->token->value;

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        return sprintf('%s COLLATE %s', $sqlWalker->walkStringPrimary($this->stringPrimary), $this->collation);
    }
}
