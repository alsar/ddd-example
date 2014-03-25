<?php
namespace Alsar\Ddd\Domain\Membership\Package;

use Alsar\Ddd\Domain\Membership\Interval;
use Money\Money;

interface Package
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return Money
     */
    public function getPrice();

    /**
     * @return Interval
     */
    public function getInterval();
}
