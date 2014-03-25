<?php
namespace Alsar\Ddd\Domain\Membership;

use Alsar\PHPUnit\TestCase;
use DateInterval;

class IntervalTest extends TestCase
{
    /**
     * @test
     */
    public function testGetDays($days = 30)
    {
        $interval = new Interval($days);

        $this->assertEquals($interval->getDays(), $days);
    }

    /**
     * @test
     */
    public function testToDateInterval($days = 30)
    {
        $interval = new Interval($days);

        $this->assertEquals($interval->toDateInterval(), new DateInterval('P30D'));
    }

    /**
     * @test
     *
     * @dataProvider invalidConstructArgumentProvider
     *
     * @expectedException Assert\InvalidArgumentException
     */
    public function testInvalidConstructorArgument($days)
    {
        $interval = new Interval($days);
    }

    /**
     * @return array
     */
    public function invalidConstructArgumentProvider()
    {
        return [['a'], [-10], [true]];
    }
}
