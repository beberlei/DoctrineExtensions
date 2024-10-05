<?php

namespace DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Node;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\TokenType;

use function in_array;
use function strtoupper;

/**
 * ExtractFunction ::= "EXTRACT" "(" Identifier "FROM" ArithmeticPrimary ")"
 *
 * @link https://dev.mysql.com/doc/refman/en/date-and-time-functions.html#function_extract
 *
 * @author Ahwalian Masykur <ahwalian@gmail.com>
 *
 * @example SELECT EXTRACT('MINUTE' FROM foo.bar) FROM entity
 * @example SELECT EXTRACT('YEAR' FROM '2024-05-06')
 */
class Extract extends DateAdd
{
    /** @var Node|string */
    public $date = null;

    /** @var int|string */
    public $unit = null;

    public function parse(Parser $parser): void
    {
        $parser->match(TokenType::T_IDENTIFIER);
        $parser->match(TokenType::T_OPEN_PARENTHESIS);

        $parser->match(TokenType::T_IDENTIFIER);
        $lexer      = $parser->getLexer();
        $this->unit = $lexer->token->value;

        $parser->match(TokenType::T_IDENTIFIER);
        $this->date = $parser->ArithmeticPrimary();

        $parser->match(TokenType::T_CLOSE_PARENTHESIS);
    }

    public function getSql(SqlWalker $sqlWalker): string
    {
        $unit = strtoupper($this->unit);
        if (! in_array($unit, self::$allowedUnits)) {
            throw QueryException::semanticalError('EXTRACT() does not support unit "' . $unit . '".');
        }

        return 'EXTRACT(' . $unit . ' FROM ' . $this->date->dispatch($sqlWalker) . ')';
    }
}
