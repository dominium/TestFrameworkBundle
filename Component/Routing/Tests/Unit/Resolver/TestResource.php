<?php

namespace Labudzinski\TestFrameworkBundle\Component\Routing\Tests\Unit\Resolver;

use Symfony\Component\Config\Resource\ResourceInterface;
use Symfony\Component\Config\Resource\SelfCheckingResourceInterface;

class TestResource implements ResourceInterface, SelfCheckingResourceInterface
{
    /** @var string */
    protected $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string)$this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($timestamp)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return $this->name;
    }
}
