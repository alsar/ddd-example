<?php
namespace Alsar\Ddd\Domain\Membership\Package;

use Alsar\Ddd\Domain\Membership\Interval;
use Money\Money;
use Alsar\PHPUnit\TestCase;

class PackageTest extends TestCase
{
    /**
     * @test
     */
    public function testConstruct()
    {
        $price = $this->getMockBuilder(Money::class)
                      ->disableOriginalConstructor()
                      ->getMock();

        $interval = $this->getMockBuilder(Interval::class)
                         ->disableOriginalConstructor()
                         ->getMock();

        $name = 'Super package';

        $package = new SelectedPackage($price, $name, $interval);

        $this->assertEquals($package->getName(), $name);
        $this->assertEquals($package->getInterval(), $interval);
        $this->assertEquals($package->getPrice(), $price);
    }

    /**
     * @test
     *
     * @expectedException Assert\InvalidArgumentException
     */
    public function testInvalidName()
    {
        $price = $this->getMockBuilder(Money::class)
                      ->disableOriginalConstructor()
                      ->getMock();

        $interval = $this->getMockBuilder(Interval::class)
                         ->disableOriginalConstructor()
                         ->getMock();

        $name = 54;

        $package = new SelectedPackage($price, $name, $interval);
    }
}
