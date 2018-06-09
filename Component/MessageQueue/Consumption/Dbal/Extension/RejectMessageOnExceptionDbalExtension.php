<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Dbal\Extension;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\AbstractExtension;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Context;

class RejectMessageOnExceptionDbalExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function onInterrupted(Context $context)
    {
        if (! $context->getException()) {
            return;
        }

        if (! $context->getMessage()) {
            return;
        }

        $context->getMessageConsumer()->reject($context->getMessage(), true);

        $context->getLogger()->debug(
            'Execution was interrupted and message was rejected. {id}',
            ['id' => $context->getMessage()->getMessageId()]
        );
    }
}
