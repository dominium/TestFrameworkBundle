<?php

namespace Labudzinski\TestFrameworkBundle\Component\Action\Action;

use Labudzinski\TestFrameworkBundle\Component\Action\Exception\InvalidParameterException;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface;

interface ActionInterface
{
    /**
     * Execute action.
     *
     * @param mixed $context
     */
    public function execute($context);

    /**
     * Initialize action based on passed options.
     *
     * @param array $options
     * @return ActionInterface
     * @throws InvalidParameterException
     */
    public function initialize(array $options);

    /**
     * Set optional condition for action
     *
     * @param ExpressionInterface $condition
     * @return mixed
     */
    public function setCondition(ExpressionInterface $condition);
}
