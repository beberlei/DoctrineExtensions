<?php

declare(strict_types=1);

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * @author Nima S <nimasdj@yahoo.com>
 */
class FromUnixtime extends FunctionNode
{
    public $firstExpression = null;

    public $secondExpression = null;

    public function getSql(SqlWalker $sqlWalker): string
    {
        if (null !== $this->secondExpression) {
            return 'FROM_UNIXTIME('
                . $this->firstExpression->dispatch($sqlWalker)
                . ','
                . $this->secondExpression->dispatch($sqlWalker)
                . ')';
        }

        return 'FROM_UNIXTIME(' . $this->firstExpression->dispatch($sqlWalker) . ')';
    }

    public function parse(Parser $parser): void
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->firstExpression = $parser->ArithmeticPrimary();

        // parse second parameter if available
        if (Lexer::T_COMMA === $lexer->lookahead->type) {
            $parser->match(Lexer::T_COMMA);
            $this->secondExpression = $parser->ArithmeticPrimary();
        }

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}
