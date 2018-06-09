<?php

namespace Labudzinski\TestFrameworkBundle\BehatStatisticExtension\TestApp;

use Behat\Behat\Context\Context;

class PingPongContext implements Context
{
    /**
     * @Given ping
     */
    public function ping()
    {
    }

    /**
     * @Then pong
     */
    public function pong()
    {
    }
}
