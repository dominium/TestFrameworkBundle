<?php

namespace Labudzinski\TestFrameworkBundle\Component\Layout;

interface ContextAwareInterface
{
    /**
     * Sets the layout context.
     *
     * @param ContextInterface $context The layout context
     */
    public function setContext(ContextInterface $context);
}
