<?php
namespace Alsar\Ddd\Domain\Membership;

use DateInterval;
use DateTimeImmutable;
use Alsar\Ddd\Domain\Membership\Package\Package;
use Alsar\Clock\FixedClock;
use Alsar\Clock\Clock;
use Alsar\Clock\SystemClock;
use Alsar\PHPUnit\TestCase;

class MembershipTest extends TestCase
{
    /**
     * @test
     */
    public function testConstruct()
    {
        $package = $this->getPackageStub('P7D');

        $clock = new FixedClock(new DateTimeImmutable('2010-06-01'));
        $membership = new Membership($package, $clock);

        $this->assertEquals($membership->getEnd(), new DateTimeImmutable('2010-06-08'));
    }

    /**
     * @test
     */
    public function testExtendWithMembershipValid()
    {
        $package1 = $this->getPackageStub('P7D');
        $package2 = $this->getPackageStub('P10D');

        $clock = $this->getClockStub();

        $clock->expects($this->at(0))
              ->method('getCurrentDate')
              ->will($this->returnValue(new DateTimeImmutable('2010-06-01')));

        $clock->expects($this->at(1))
              ->method('getCurrentDate')
              ->will($this->returnValue(new DateTimeImmutable('2010-06-03')));

        $membership = new Membership($package1, $clock);

        $membership->extend($package2);

        $this->assertEquals($membership->getEnd(), new DateTimeImmutable('2010-06-18'));
    }

    /**
     * @test
     */
    public function testExtendWithMembershipInvalid()
    {
        $package1 = $this->getPackageStub('P7D');
        $package2 = $this->getPackageStub('P10D');
        $clock = $this->getClockStub();

        $clock->expects($this->at(0))
              ->method('getCurrentDate')
              ->will($this->returnValue(new DateTimeImmutable('2010-06-10')));

        $clock->expects($this->at(1))
              ->method('getCurrentDate')
              ->will($this->returnValue(new DateTimeImmutable('2010-07-01')));

        $membership = new Membership($package1, $clock);

        $membership->extend($package2);

        $this->assertEquals($membership->getEnd(), new DateTimeImmutable('2010-07-11'));
    }

    /**
     * @return Clock
     */
    public function getClockStub()
    {
        return $this->getMockBuilder(SystemClock::class)
                    ->disableOriginalConstructor()
                    ->getMock();
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
}
