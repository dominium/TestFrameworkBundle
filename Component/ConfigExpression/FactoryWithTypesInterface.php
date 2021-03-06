<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression;

interface FactoryWithTypesInterface
{
    /**
     * @return string[]
     */
    public function getTypes();

    /**
     * @param string $name
     * @return bool
     */
    public function isTypeExists($name);
}
