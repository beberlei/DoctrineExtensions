<?php
/**
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

use Doctrine\ORM\Query\AST\Functions\FunctionNode;

class Atan extends FunctionNode
{

	public $arithmeticExpression;
	public $optionalSecondExpression;

	public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
	{

		$secondArgument = '';

		if ($this->optionalSecondExpression) {

			$secondArgument = $sqlWalker->walkArithmeticExpression(
				$this->optionalSecondExpression
			);

		}

		return $this->_functionName .
			'(' . $sqlWalker->walkArithmeticExpression(
				$this->arithmeticExpression
			) . (($secondArgument) ? ', ' . $secondArgument : '')
		. ')';

	}

	public function parse(\Doctrine\ORM\Query\Parser $parser)
	{

	}

}