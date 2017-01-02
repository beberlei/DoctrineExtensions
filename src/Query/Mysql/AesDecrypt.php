<?php

namespace BoaCompra\DoctrineExtensions\Query\Mysql;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class AesDecrypt extends FunctionNode
{

    public $field = '';
    public $key = '';

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->field = $parser->StringExpression();
        $parser->match(Lexer::T_COMMA);
        $this->key = $parser->StringExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf(
            'AES_DECRYPT(%s, %s)',
            $this->field->dispatch($sqlWalker),
            $this->key->dispatch($sqlWalker)
        );
    }
}
