<?php
namespace Alsar\Ddd\Domain\Membership;

use Alsar\Clock\Clock;
use Alsar\Ddd\Domain\Membership\Package\Package;
use Alsar\Ddd\Domain\Membership\Package\SelectedPackage;
use Assert\Assertion;
use Money\Money;

class MembershipFactory
{
    const PROMOTIONAL_PRICE = 0;

    /**
     * @var Clock
     */
    protected $clock;

    public function __construct(Clock $clock)
    {
        $this->clock = $clock;
    }

    /**
     * TODO: preimenovati v createFromAvailablePackage?
     * FIXME: je sploh smiselno imeti factory za tole?
     *
     * @param AvailablePackage $package
     *
     * @return Membership
     */
    public function createPaid(Package $package)
    {
        return new Membership($package, $this->clock);
    }

    /**
     * @param string $packageName
     * @param string $numberOfDays
     *
     * @return Membership
     */
    public function createPromotional($packageName, $numberOfDays)
    {
        Assertion::string($packageName);
        Assertion::integer($numberOfDays);
        Assertion::min($numberOfDays, 0);

        $interval = new Interval($numberOfDays);

        $promotionalPackage = new SelectedPackage(Money::EUR(self::PROMOTIONAL_PRICE), $packageName, $interval);

        return new Membership($promotionalPackage, $this->clock);
    }
}
