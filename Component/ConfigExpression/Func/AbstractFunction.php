<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Func;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\AbstractExpression;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ContextAccessorAwareInterface;
use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\ContextAccessorAwareTrait;

abstract class AbstractFunction extends AbstractExpression implements ContextAccessorAwareInterface
{
    use ContextAccessorAwareTrait;
}
