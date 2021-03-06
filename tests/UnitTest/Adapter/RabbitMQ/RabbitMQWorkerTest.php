<?php

namespace Test\MyCLabs\Work\UnitTest\Adapter\RabbitMQ;

use MyCLabs\Work\Adapter\RabbitMQ\RabbitMQWorker;
use PHPUnit_Framework_TestCase;

/**
 * @covers \MyCLabs\Work\Adapter\RabbitMQ\RabbitMQWorker
 */
class RabbitMQWorkerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider range
     */
    public function testLimitNumberOfTask($times)
    {
        $channel = $this->getMock(
            'PhpAmqpLib\Channel\AMQPChannel',
            ['basic_qos', 'basic_consume', 'wait'],
            [],
            '',
            false
        );
        $channel->callbacks = 1;

        // Check that it will loop only X times
        $channel->expects($this->exactly($times))
            ->method('wait');

        $worker = new RabbitMQWorker($channel, '');
        $worker->work($times);
    }

    public function range()
    {
        return [
            [0],
            [1],
            [2],
            [3]
        ];
    }
}
