<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Condition;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\AbstractExpression;

abstract class AbstractCondition extends AbstractExpression
{
    /**
     * {@inheritdoc}
     *
     * @return boolean
     */
    protected function doEvaluate($context)
    {
        $result = $this->isConditionAllowed($context);
        if (!$result) {
            $this->addError($context);
        }

        return $result;
    }

    /**
     * Checks if context meets the condition requirements.
     *
     * @param mixed $context
     *
     * @return boolean
     */
    abstract protected function isConditionAllowed($context);
}
