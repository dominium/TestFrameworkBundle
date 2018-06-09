<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ContextInterface;
use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ProcessorInterface;

class ProcessorMock implements ProcessorInterface
{
    /** @var string */
    protected $processorId;

    /** @var callable|null */
    protected $callback;

    /**
     * @param string|null   $processorId
     * @param callable|null $callback
     */
    public function __construct($processorId = null, $callback = null)
    {
        $this->processorId = $processorId;
        $this->callback    = $callback;
    }

    /**
     * @return string
     */
    public function getProcessorId()
    {
        return $this->processorId;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContextInterface $context)
    {
        if (null !== $this->callback) {
            call_user_func($this->callback, $context);
        }
    }
}
