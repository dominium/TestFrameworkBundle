<?php

namespace Labudzinski\TestFrameworkBundle\Component\ChainProcessor\Tests\Unit;

use Labudzinski\TestFrameworkBundle\Component\ChainProcessor\ToArrayInterface;

class TestArrayObject implements ToArrayInterface
{
    /** @var array */
    protected $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->items;
    }
}
