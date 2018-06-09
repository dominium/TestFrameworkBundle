<?php

namespace Labudzinski\TestFrameworkBundle\Fixtures;

use Labudzinski\TestFrameworkBundle\Migrations\Data\ORM\AbstractLoadUserData;

/**
 * @deprecated since 1.10
 *
 * @see \Labudzinski\TestFrameworkBundle\Migrations\Data\ORM\LoadUserData
 */
class LoadUserData extends AbstractLoadUserData
{
    /**
     * @return int
     *
     * @deprecated since 1.10
     */
    public function getOrder()
    {
        return 110;
    }
}
