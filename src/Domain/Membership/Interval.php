<?php
namespace Alsar\Ddd\Domain\Membership;

use Assert\Assertion;
use DateInterval;

class Interval
{
    /**
     * @var integer
     */
    protected $days;

    /**
     * @param integer $days
     */
    public function __construct($days)
    {
        Assertion::integer($days);
        Assertion::min($days, 0);

        $this->days = $days;
    }

    /**
     * @return integer
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @return DateInterval
     */
    public function toDateInterval()
    {
        return new DateInterval(sprintf('P%sD', $this->days));
    }
}
