<?php
namespace Alsar\ValueObject;

use DateTimeImmutable;
use Alsar\PHPUnit\TestCase;

class DateTimeRangeTest extends TestCase
{
    /**
     * @test
     * @expectedException Assert\InvalidArgumentException
     */
    public function testConstructEndDateBeforeStartDateException()
    {
        new DateTimeRange(new DateTimeImmutable('2000-10-10'), new DateTimeImmutable('2000-01-01'));
    }

    /**
     * @test
     */
    public function testStartDateBeforeEndDate()
    {
       $range = new DateTimeRange(new DateTimeImmutable('2010-01-01'), new DateTimeImmutable('2010-10-10'));

       $this->assertTrue($range->getStart() < $range->getEnd());
    }

    /**
     * @test
     */
    public function testToString()
    {
       $range = new DateTimeRange(new DateTimeImmutable('2010-01-01'), new DateTimeImmutable('2010-10-10'));

       $this->assertEquals((string) $range, '2010-01-01 00:00:00 - 2010-10-10 00:00:00');
    }
}
