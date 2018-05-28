<?php

namespace DoctrineExtensions\Query\Mysql;

use  Doctrine\ORM\Query\AST\Functions\FunctionNode;
use  Doctrine\ORM\Query\Lexer;
use  Doctrine\ORM\Query\Parser;
use  Doctrine\ORM\Query\SqlWalker;

/**
 * Class Substring
 * @package DoctrineExtensions\Query\Mysql
 * @author Ivan P <ivan@petrunko.com>
 */
class Substring extends FunctionNode
{
    public $string = null;
    public $position = null;
    public $length = null;

    /**
     * @param \Doctrine\ORM\Query\Parser $parser
     */
    public function parse(Parser $parser)
    {
        $lexer = $parser->getLexer();

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->string = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->position = $parser->ArithmeticFactor();
        if ($lexer->lookahead['type'] !== Lexer::T_CLOSE_PARENTHESIS) {
            $parser->match(Lexer::T_COMMA);
            $this->length = $parser->ArithmeticPrimary();
        }
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param \Doctrine\ORM\Query\SqlWalker $sqlWalker
     * @return string
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        if ($this->length) {
            return sprintf('SUBSTRING(%s, %s, %s)',
                $this->string->dispatch($sqlWalker),
                $this->position->dispatch($sqlWalker),
                $this->length->dispatch($sqlWalker)
            );
        }
        return sprintf('SUBSTRING(%s, %s)',
            $this->string->dispatch($sqlWalker),
            $this->position->dispatch($sqlWalker)
        );
    }
}
