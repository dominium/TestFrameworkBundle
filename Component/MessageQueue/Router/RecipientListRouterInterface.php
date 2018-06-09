<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Router;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Transport\MessageInterface;

interface RecipientListRouterInterface
{
    /**
     * @param MessageInterface $message
     *
     * @return \Traversable|Recipient[]
     */
    public function route(MessageInterface $message);
}
