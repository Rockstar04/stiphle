<?php
/**
 * @package
 * @subpackage
 */
namespace Stiphle\Throttle;

use PHPUnit\Framework\TestCase;
use Storage\Process;

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
 *
 * @coversDefaultClass \Stiphle\Throttle\LeakyBucket
 */
class LeakyBucketTest extends TestCase
{
    protected $storage = null;

    public function setup()
    {
        $this->throttle = new LeakyBucket();
    }

    /**
     * @group throttle
     * @covers ::throttle
     * @covers ::getNewRatio
     * @covers ::getStorageKey
     * @covers ::setLastRatio
     * @covers ::setLastRequest
     */
    public function testThrottle()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * This test assumes your machine is capable of processing the first five
     * calls in less that a second :)
     *
     * Nothing special here, ideally we need to mock the storage out and test it
     * with different values etc
     *
     * @group throttle
     * @covers ::getEstimate
     * @covers ::getNewRatio
     * @covers ::getStorageKey
     */
    public function testGetEstimate()
    {
        $this->assertEquals(0, $this->throttle->throttle('dave', 5, 1000));
        $this->assertEquals(0, $this->throttle->throttle('dave', 5, 1000));
        $this->assertEquals(0, $this->throttle->throttle('dave', 5, 1000));
        $this->assertEquals(0, $this->throttle->throttle('dave', 5, 1000));
        $this->assertEquals(0, $this->throttle->throttle('dave', 5, 1000));
        $this->assertGreaterThan(0, $this->throttle->getEstimate('dave', 5, 1000));
        $this->assertGreaterThan(0, $this->throttle->throttle('dave', 5, 1000));
    }

    /**
     * @group throttle
     */
    public function testSetStorage()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
