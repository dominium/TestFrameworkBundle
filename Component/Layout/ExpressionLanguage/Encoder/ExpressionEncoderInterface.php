<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout\ExpressionLanguage\Encoder;

use Labudzinski\TestFrameworkBundle\Component\Layout\Action;
use Symfony\Component\ExpressionLanguage\ParsedExpression;

interface ExpressionEncoderInterface
{
    /**
     * Returns string representation of the given expression.
     *
     * @param ParsedExpression $expr
     *
     * @return string
     */
    public function encodeExpr(ParsedExpression $expr);

    /**
     * Returns string representation of the given action.
     *
     * @param Action[] $actions
     *
     * @return string
     */
    public function encodeActions($actions);
}
