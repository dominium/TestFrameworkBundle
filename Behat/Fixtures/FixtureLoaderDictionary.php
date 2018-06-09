<?php

namespace Labudzinski\TestFrameworkBundle\Behat\Fixtures;

trait FixtureLoaderDictionary
{
    /**
     * @var FixtureLoader
     */
    protected $fixtureLoader;

    /**
     * {@inheritdoc}
     */
    public function setFixtureLoader(FixtureLoader $fixtureLoader)
    {
        $this->fixtureLoader = $fixtureLoader;
    }
}
