<?php
namespace Alsar\Ddd\Domain\Membership;

use Alsar\Ddd\Domain\Membership\Package\Package;
use Alsar\Clock\Clock;
use Alsar\Clock\SystemClock;
use Alsar\PHPUnit\TestCase;
use DateInterval;
use DateTimeImmutable;

class MembershipFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function testPaid()
    {
        $package = $this->getPackageStub('P7D');

        $clock = $this->getClockStub();

        $clock->expects($this->at(0))
              ->method('getCurrentDate')
              ->will($this->returnValue(new DateTimeImmutable('2010-06-01')));

        $factory = new MembershipFactory($clock);

        $membership = $factory->createPaid($package);

        // ???
        $this->assertEquals($membership->getEnd(), new DateTimeImmutable('2010-06-08'));
    }

    /**
     * @test
     */
    public function testPromotional()
    {
        $numberOfDays = 10;
        $clock = $this->getClockStub();

        $clock->expects($this->at(0))
              ->method('getCurrentDate')
              ->will($this->returnValue(new DateTimeImmutable('2010-06-01')));

        $factory = new MembershipFactory($clock);

        $membership = $factory->createPromotional('Promo', $numberOfDays);

        // ???
        $this->assertEquals($membership->getEnd(), new DateTimeImmutable('2010-06-11'));
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
     * @return Clock
     */
    public function getClockStub()
    {
        return $this->getMockBuilder(SystemClock::class)
                    ->disableOriginalConstructor()
                    ->getMock();
    }
}
