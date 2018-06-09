<?php

namespace Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Tests\Unit\Fixtures;

use Labudzinski\TestFrameworkBundle\Component\ConfigExpression\Extension\AbstractExtension;

class AbstractExtensionStub extends AbstractExtension
{
    /** @var array */
    protected $loadedExpressions;

    /**
     * @param array $loadedExpressions
     */
    public function __construct($loadedExpressions)
    {
        $this->loadedExpressions = $loadedExpressions;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadExpressions()
    {
        return $this->loadedExpressions;
    }
}
