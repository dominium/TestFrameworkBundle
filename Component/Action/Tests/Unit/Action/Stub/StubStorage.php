<?php

namespace Labudzinski\TestFrameworkBundle\Component\Action\Tests\Unit\Action\Stub;

use Labudzinski\TestFrameworkBundle\Component\Action\Model\AbstractStorage;

class StubStorage extends AbstractStorage
{
    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
