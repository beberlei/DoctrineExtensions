<?php
/**
 * DoctrineExtensions Paginate
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE. This license can also be viewed
 * at http://hobodave.com/license.txt
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Paginate
 * @author      David Abdemoulaie <dave@hobodave.com>
 * @copyright   Copyright (c) 2010 David Abdemoulaie (http://hobodave.com/)
 * @license     http://hobodave.com/license.txt New BSD License
 */

namespace DoctrineExtensions\Paginate;

use Doctrine\ORM\Query\TreeWalkerAdapter,
    Doctrine\ORM\Query\AST\SelectStatement,
    Doctrine\ORM\Query\AST\PathExpression,
    Doctrine\ORM\Query\AST\InExpression,
    Doctrine\ORM\Query\AST\NullComparisonExpression,
    Doctrine\ORM\Query\AST\InputParameter,
    Doctrine\ORM\Query\AST\ConditionalPrimary,
    Doctrine\ORM\Query\AST\ConditionalTerm,
    Doctrine\ORM\Query\AST\ConditionalExpression,
    Doctrine\ORM\Query\AST\ConditionalFactor,
    Doctrine\ORM\Query\AST\WhereClause;

/**
 * Replaces the whereClause of the AST with a WHERE id IN (:foo_1, :foo_2) equivalent
 *
 * @category    DoctrineExtensions
 * @package     DoctrineExtensions\Paginate
 * @author      David Abdemoulaie <dave@hobodave.com>
 * @copyright   Copyright (c) 2010 David Abdemoulaie (http://hobodave.com/)
 * @license     http://hobodave.com/license.txt New BSD License
 */
class WhereInWalker extends TreeWalkerAdapter
{
    /**
     * Replaces the whereClause in the AST
     *
     * Generates a clause equivalent to WHERE IN (:pgid_1, :pgid_2, ...)
     *
     * The parameter namespace (pgid) is retrieved from the pg.ns query hint
     * The total number of parameters is retrieved from the id.count query hint
     *
     * @param  SelectStatement $AST
     * @return void
     */
    public function walkSelectStatement(SelectStatement $AST)
    {
        $parent = null;
        $parentName = null;
        foreach ($this->_getQueryComponents() AS $dqlAlias => $qComp) {
            if ($qComp['parent'] === null && $qComp['nestingLevel'] == 0) {
                $parent = $qComp;
                $parentName = $dqlAlias;
                break;
            }
        }

        $pathExpression = new PathExpression(
            PathExpression::TYPE_STATE_FIELD, $parentName, $parent['metadata']->getSingleIdentifierFieldName()
        );
        $pathExpression->type = PathExpression::TYPE_STATE_FIELD;

        $count = $this->_getQuery()->getHint('id.count');

        if ($count > 0) {
            $expression = new InExpression($pathExpression);
            $ns = $this->_getQuery()->getHint('pg.ns');

            for ($i=1; $i <= $count; $i++) {
                $expression->literals[] = new InputParameter(":{$ns}_$i");
            }

        } else {
            $expression = new NullComparisonExpression($pathExpression);
            $expression->not = false;
        }

        $conditionalPrimary = new ConditionalPrimary;
        $conditionalPrimary->simpleConditionalExpression = $expression;
        if(
            $AST->whereClause instanceof WhereClause
            && $AST->whereClause->conditionalExpression
        ) {
            $AST->whereClause = new WhereClause(
                new ConditionalTerm(array(
                    new ConditionalFactor($conditionalPrimary),
                    $AST->whereClause->conditionalExpression
                ))
            );
        } else {
            $AST->whereClause = new WhereClause(
                new ConditionalExpression(array(
                    new ConditionalTerm(array(
                        new ConditionalFactor($conditionalPrimary)
                    ))
                ))
            );
        }
    }
}
