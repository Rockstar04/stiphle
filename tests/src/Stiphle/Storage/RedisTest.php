<?php
/* vim: set ts=4 sw=4 tw=0 et :*/

namespace Stiphle\Storage;

use PHPUnit\Framework\TestCase;

class RedisTest extends TestCase
{
    /**
     * @group storage
     */
    public function testLockThrowsLockWaitTimeoutException()
    {
        $redisClient = $this->getMockBuilder(\Predis\Client::class)
                            ->setMethods(['set'])
                            ->getMock();

        $redisClient->expects($this->at(0))
            ->method('set')
            ->with('dave::LOCK', 'LOCKED', 'PX', 3600, 'NX')
            ->will($this->returnValue(1));

        $redisClient->expects($this->any())
            ->method('set')
            ->with('dave::LOCK', 'LOCKED', 'PX', 3600, 'NX')
            ->will($this->returnValue(null));

        $this->expectException(\Stiphle\Storage\LockWaitTimeoutException::class);

        $storage = new Redis($redisClient);

        $storage->lock('dave');
        $storage->lock('dave');
    }

    /**
     * @group storage
     */
    public function testStorageCanBeUnlocked()
    {
        $redisClient = $this->getMockBuilder(\Predis\Client::class)
                            ->setMethods(['del'])
                            ->getMock();

        $redisClient->expects($this->once())
            ->method('del')
            ->with('dave::LOCK');

        $storage = new Redis($redisClient);

        $storage->unlock('dave');
    }
}
