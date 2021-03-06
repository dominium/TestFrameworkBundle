<?php

namespace Labudzinski\TestFrameworkBundle\Tests\Functional\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Labudzinski\TestFrameworkBundle\Test\DataFixtures\InitialFixtureInterface;

/**
 * Loads the first user from the database.
 */
class LoadUser extends AbstractFixture implements InitialFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = $manager->getRepository('OroUserBundle:User')
            ->createQueryBuilder('t')
            ->orderBy('t.id')
            ->getQuery()
            ->setMaxResults(1)
            ->getSingleResult();
        $this->addReference('user', $user);
    }
}
