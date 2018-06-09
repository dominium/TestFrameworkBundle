<?php

namespace Labudzinski\TestFrameworkBundle\Component\Action\Action;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ExpressionInterface;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\FactoryWithTypesInterface;

interface ActionFactoryInterface extends FactoryWithTypesInterface
{
    /**
     * Creates an action.
     *
     * @param string $type
     * @param array $options
     * @param ExpressionInterface $condition
     * @throws \RunTimeException
     * @return ActionInterface
     */
    public function create($type, array $options = array(), ExpressionInterface $condition = null);
}
