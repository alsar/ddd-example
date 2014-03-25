<?php
namespace Alsar\Ddd\Domain\Membership;

use DateInterval;
use DateTimeImmutable;
use Alsar\Ddd\Domain\Membership\Package\Package;
use Alsar\PHPUnit\TestCase;

class PeriodTest extends TestCase
{
    /**
     * @test
     */
    public function testConstructEndDate()
    {
        $package = $this->getPackageStub('P7D');

        $startDate = new DateTimeImmutable('2000-01-01');

        $period = new Period($startDate, $package);

        $testEndDate = $startDate->add(new DateInterval('P7D'));

        $this->assertEquals($period->getEnd(), $testEndDate);
    }

    /**
     * @test
     *
     * @dataProvider inRangeProvider
     */
    public function testInRange(DateTimeImmutable $startDate, $intervalSpec, DateTimeImmutable $verificationDate)
    {
        $package = $this->getPackageStub($intervalSpec);

        $period = new Period($startDate, $package);

        $this->assertTrue($period->isInRange($verificationDate));
    }

    /**
     * @test
     *
     * @dataProvider outOfRangeProvider
     */
    public function testOutOfRange(DateTimeImmutable $startDate, $intervalSpec, DateTimeImmutable $verificationDate)
    {
        $package = $this->getPackageStub($intervalSpec);

        $period = new Period($startDate, $package);

        $this->assertFalse($period->isInRange($verificationDate));
    }

    /**
     * @param string $intervalSpec
     *
     * @return Package
     */
    protected function getPackageStub($intervalSpec)
    {
        $interval = $this->getMockBuilder(Interval::class)
                         ->disableOriginalConstructor()
                         ->getMock();

        $interval->expects($this->any())
                 ->method('toDateInterval')
                 ->will($this->returnValue(new DateInterval($intervalSpec)));

        $package = $this->getMock(Package::class);

        $package->expects($this->any())
                ->method('getInterval')
                ->will($this->returnValue($interval));

        return $package;
    }

    /**
     * @return array
     */
    public function inRangeProvider()
    {
        return [
            [new DateTimeImmutable('2000-01-01'), 'P10D', new DateTimeImmutable('2000-01-11')],
            [new DateTimeImmutable('2000-01-01'), 'P10D', new DateTimeImmutable('2000-01-10')],
            [new DateTimeImmutable('2000-01-01'), 'P10D', new DateTimeImmutable('2000-01-01')],
            [new DateTimeImmutable('2000-01-01'), 'P10D', new DateTimeImmutable('2000-01-02')],
        ];
    }

    /**
     * @return array
     */
    public function outOfRangeProvider()
    {
        return [
            [new DateTimeImmutable('2000-01-01'), 'P10D', new DateTimeImmutable('1999-12-31')],
            [new DateTimeImmutable('2000-01-01'), 'P10D', new DateTimeImmutable('2000-01-12')],
        ];
    }
}
