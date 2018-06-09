<?php

namespace Labudzinski\TestFrameworkBundle\Test\DataFixtures;

interface FixtureIdentifierResolverInterface
{
    /**
     * Returns a string that uniquely identifies a given fixture.
     *
     * @param mixed $fixture
     *
     * @return string
     */
    public function resolveId($fixture);
}
