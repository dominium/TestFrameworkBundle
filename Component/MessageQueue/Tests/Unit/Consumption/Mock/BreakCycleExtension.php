<?php
namespace Labudzinski\TestFrameworkBundle\Component\MessageQueue\Tests\Unit\Consumption\Mock;

use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\AbstractExtension;
use Labudzinski\TestFrameworkBundle\Component\MessageQueue\Consumption\Context;

class BreakCycleExtension extends AbstractExtension
{
    protected $cycles = 1;

    private $limit;

    public function __construct($limit)
    {
        $this->limit = $limit;
    }

    public function onPostReceived(Context $context)
    {
        $this->onIdle($context);
    }

    public function onIdle(Context $context)
    {
        if ($this->cycles >= $this->limit) {
            $context->setExecutionInterrupted(true);
        } else {
            $this->cycles++;
        }
    }
}
