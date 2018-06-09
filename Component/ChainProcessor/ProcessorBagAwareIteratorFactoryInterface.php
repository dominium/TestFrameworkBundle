<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor;

/**
 * This interface should be implemented by processor iterator factory that depends on a ProcessorBag.
 */
interface ProcessorBagAwareIteratorFactoryInterface
{
    /**
     * Sets the ProcessorBag.
     *
     * @param ProcessorBagInterface|null $processorBag A ProcessorBagInterface instance or null
     */
    public function setProcessorBag(ProcessorBagInterface $processorBag = null);
}
