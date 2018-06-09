<?php

namespace Labudzinski\TestFrameworkBundle\Behat\Isolation;

use Labudzinski\TestFrameworkBundle\Behat\Isolation\Event\AfterFinishTestsEvent;
use Labudzinski\TestFrameworkBundle\Behat\Isolation\Event\AfterIsolatedTestEvent;
use Labudzinski\TestFrameworkBundle\Behat\Isolation\Event\BeforeIsolatedTestEvent;
use Labudzinski\TestFrameworkBundle\Behat\Isolation\Event\BeforeStartTestsEvent;
use Labudzinski\TestFrameworkBundle\Behat\Isolation\Event\RestoreStateEvent;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class KernelIsolator implements IsolatorInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /** {@inheritdoc} */
    public function start(BeforeStartTestsEvent $event)
    {
        $event->writeln('<info>Booting the Kernel</info>');
        $this->kernel->boot();
    }

    /** {@inheritdoc} */
    public function beforeTest(BeforeIsolatedTestEvent $event)
    {
        $this->kernel->boot();
    }

    /** {@inheritdoc} */
    public function afterTest(AfterIsolatedTestEvent $event)
    {
        $this->kernel->shutdown();
        $this->kernel->boot();
    }

    /** {@inheritdoc} */
    public function terminate(AfterFinishTestsEvent $event)
    {
        $this->kernel->shutdown();
    }

    /** {@inheritdoc} */
    public function isApplicable(ContainerInterface $container)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isOutdatedState()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function restoreState(RestoreStateEvent $event)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Kernel';
    }

    /**
     * {@inheritdoc}
     */
    public function getTag()
    {
        return 'kernel';
    }
}
