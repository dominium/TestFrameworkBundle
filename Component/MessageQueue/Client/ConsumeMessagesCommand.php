<?php

namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Client\Meta\DestinationMetaRegistry;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\ChainExtension;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Extension\LoggerExtension;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\ExtensionInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\LimitsExtensionsCommandTrait;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\MessageProcessorInterface;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\QueueConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ConsumeMessagesCommand extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    use LimitsExtensionsCommandTrait;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->configureLimitsExtensions();

        $this
            ->setName('oro:message-queue:consume')
            ->setDescription('A client\'s worker that processes messages. '.
                'By default it connects to default queue. '.
                'It select an appropriate message processor based on a message headers')
            ->addArgument('clientDestinationName', InputArgument::OPTIONAL, 'Queues to consume messages from');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $consumer = $this->getConsumer();
        $clientDestinationName = $input->getArgument('clientDestinationName');
        if ($clientDestinationName) {
            $consumer->bind(
                $this->getDestinationMetaRegistry()->getDestinationMeta($clientDestinationName)->getTransportName(),
                $this->getProcessor()
            );
        } else {
            foreach ($this->getDestinationMetaRegistry()->getDestinationsMeta() as $destinationMeta) {
                $consumer->bind(
                    $destinationMeta->getTransportName(),
                    $this->getProcessor()
                );
            }
        }

        $extensions = $this->getLimitsExtensions($input, $output);
        array_unshift($extensions, $this->getLoggerExtension($input, $output));

        $this->consume($consumer, $this->getConsumerExtension($extensions));
    }

    /**
     * @param QueueConsumer      $consumer
     * @param ExtensionInterface $extension
     */
    protected function consume(QueueConsumer $consumer, ExtensionInterface $extension)
    {
        try {
            $consumer->consume($extension);
        } finally {
            $consumer->getConnection()->close();
        }
    }

    /**
     * @param array $extensions
     *
     * @return ExtensionInterface
     */
    protected function getConsumerExtension(array $extensions)
    {
        return new ChainExtension($extensions);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return ExtensionInterface
     */
    protected function getLoggerExtension(InputInterface $input, OutputInterface $output)
    {
        return new LoggerExtension(new ConsoleLogger($output));
    }

    /**
     * @return QueueConsumer
     */
    private function getConsumer()
    {
        return $this->container->get('oro_message_queue.client.queue_consumer');
    }

    /**
     * @return DestinationMetaRegistry
     */
    private function getDestinationMetaRegistry()
    {
        return $this->container->get('oro_message_queue.client.meta.destination_meta_registry');
    }

    /**
     * @return MessageProcessorInterface
     */
    private function getProcessor()
    {
        return $this->container->get('oro_message_queue.client.delegate_message_processor');
    }
}
