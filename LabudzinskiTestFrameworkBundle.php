<?php

namespace Labudzinski\TestFrameworkBundle;

use Labudzinski\TestFrameworkBundle\DependencyInjection\Compiler\CheckReferenceCompilerPass;
use Labudzinski\TestFrameworkBundle\DependencyInjection\Compiler\ClientCompilerPass;
use Labudzinski\TestFrameworkBundle\DependencyInjection\Compiler\TagsInformationPass;
use Labudzinski\TestFrameworkBundle\DependencyInjection\Compiler\TestSessionListenerCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LabudzinskiTestFrameworkBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new TagsInformationPass());
        $container->addCompilerPass(new CheckReferenceCompilerPass());
        $container->addCompilerPass(new ClientCompilerPass());
        $container->addCompilerPass(new TestSessionListenerCompilerPass());
    }
}
