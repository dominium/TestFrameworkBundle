<?php

namespace Labudzinski\TestFrameworkBundle\Behat\Element;

class Checkbox extends Element
{
    public function setValue($value)
    {
        if (in_array($value, [false, 'false', 'uncheck', 'unselect'], true)) {
            $this->uncheck();
        } else {
            $this->check();
        }
    }
}
