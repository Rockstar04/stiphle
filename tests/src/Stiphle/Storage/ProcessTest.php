<?php
/**
 * @package
 * @subpackage
 */
namespace Stiphle\Storage;

use phpmock\phpunit\PHPMock as FunctionMockTrait;
use PHPUnit\Framework\TestCase;

/**
 * This file is part of Stiphle
 *
 * Copyright (c) 2011 Dave Marshall <dave.marshall@atstsolutuions.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * TITLE
 *
 * DESCRIPTION
 *
 * @author      Dave Marshall <david.marshall@atstsolutions.co.uk>
 */
class ProcessTest extends TestCase
{
    use FunctionMockTrait;

    protected $storage = null;

    public function setup()
    {
        $this->storage = new Process();
    }

    /**
     * @group storage
     */
    public function testLockAndUnlock()
    {
        $time = $this->getFunctionMock(__NAMESPACE__, 'microtime');
        $time->expects($this->any())->will($this->onConsecutiveCalls(0.5, 0.501, 1, 1.5, 2, PHP_INT_MAX));

        $this->storage->lock('dave');
        $this->assertAttributeEquals(['dave' => true], 'locked', $this->storage);
        $this->storage->unlock('dave');
        $this->assertAttributeEquals(['dave' => false], 'locked', $this->storage);
    }

    /**
     * @group storage
     */
    public function testGetAndSet()
    {
        $this->storage->set('dave', 10);
        $this->assertAttributeEquals(['dave' => 10], 'values', $this->storage);
        $value = $this->storage->get('dave');
        $this->assertEquals(10, $value);
    }

    /**
     * @group storage
     */
    public function testGetNull()
    {
        $value = $this->storage->get('dave');
        $this->assertEquals(null, $value);
    }

    /**
     * @group storage
     * @expectedException Stiphle\Storage\LockWaitTimeoutException
     */
    public function testLockThrowsLockWaitTimeoutException()
    {
        $time = $this->getFunctionMock(__NAMESPACE__, 'microtime');
        $time->expects($this->any())->will($this->onConsecutiveCalls(0.5, 0.501, 1, 1.5, 2, PHP_INT_MAX));

        $this->storage->lock('dave');
        $this->storage->lock('dave');
    }

    /**
     * @group storage
     * @expectedException Stiphle\Storage\LockWaitTimeoutException
     */
    public function testLockRespectsLockWaitTimeoutValue()
    {
        $time = $this->getFunctionMock(__NAMESPACE__, 'microtime');
        $time->expects($this->exactly(6))->will($this->onConsecutiveCalls(0.5, 0.501, 1, 1.5, 2, PHP_INT_MAX));

        $this->storage->lock('dave');
        $this->storage->setLockWaitTimeout(2000);
        $this->storage->lock('dave');
    }
}
