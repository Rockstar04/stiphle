<?php

namespace Stiphle\Throttle;

use phpmock\phpunit\PHPMock as FunctionMockTrait;
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
 */
class TimeWindowTest extends TestCase
{
    use FunctionMockTrait;

    protected $storage = null;

    public function setup()
    {
        $this->throttle = new TimeWindow();
    }

    /**
     * Really crap test here, without mocking the system time, it's difficult to
     * know when you're going to throttled...
     *
     * @group throttle
     */
    public function testGetEstimate()
    {
        $timeout = strtotime('+5 seconds', microtime(1));
        $count = 0;
        while (microtime(1) < $timeout) {
            $this->throttle->throttle('dave', 5, 1000);
            if (microtime(1) < $timeout) {
                $count++;
            }
        }

        $this->assertEquals(25, $count);
    }
}
