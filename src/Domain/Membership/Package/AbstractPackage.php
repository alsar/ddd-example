<?php
namespace Alsar\Ddd\Domain\Membership\Package;

use Alsar\Ddd\Domain\Membership\Interval;
use Assert\Assertion;
use Money\Money;

abstract class AbstractPackage implements Package
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Money
     */
    protected $price;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var DateInterval
     */
    protected $interval;

    /**
     * @param Money        $price
     * @param string       $name
     * @param DateInterval $interval
     */
    public function __construct(Money $price, $name, Interval $interval)
    {
        Assertion::string($name);

        $this->price    = $price;
        $this->name     = $name;
        $this->interval = $interval;
    }

    /**
     * {@inheritdoc}
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * {@inheritdoc}
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
}
