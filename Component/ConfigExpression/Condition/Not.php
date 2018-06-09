<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Condition;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Exception;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface;

/**
 * Implements logical NOT operator.
 */
class Not extends AbstractCondition
{
    /** @var ExpressionInterface */
    protected $operand;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'not';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->convertToArray($this->operand);
    }

    /**
     * {@inheritdoc}
     */
    public function compile($factoryAccessor)
    {
        return $this->convertToPhpCode($this->operand, $factoryAccessor);
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(array $options)
    {
        if (1 === count($options)) {
            $operand = reset($options);
            if ($operand instanceof ExpressionInterface) {
                $this->operand = $operand;
            } else {
                throw new Exception\UnexpectedTypeException(
                    $operand,
                    'Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface',
                    'Invalid option type.'
                );
            }
        } else {
            throw new Exception\InvalidArgumentException(
                sprintf('Options must have 1 element, but %d given.', count($options))
            );
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function isConditionAllowed($context)
    {
        return !$this->operand->evaluate($context, $this->errors);
    }
}
