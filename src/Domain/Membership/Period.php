<?php
namespace Alsar\Ddd\Domain\Membership;

use Alsar\Ddd\Domain\Membership\Package\Package;
use Alsar\ValueObject\DateTimeRange;
use DateTimeImmutable;

class Period
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var DateTimeRange
     */
    protected $range;

    /**
     * @var DateTimeImmutable
     */
    protected $createdAt;

    /**
     * @var Package
     */
    protected $package;

    /**
     * @param DateTimeImmutable $start
     * @param Package           $package
     */
    public function __construct(DateTimeImmutable $start, Package $package)
    {
        $end = $start->add($package->getInterval()->toDateInterval());

        $this->range     = new DateTimeRange($start, $end);
        $this->createdAt = new DateTimeImmutable();
        $this->package   = $package;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEnd()
    {
        return $this->range->getEnd();
    }

    /**
     * @param DateTimeImmutable $date
     *
     * @return boolean
     */
    public function isInRange(DateTimeImmutable $date)
    {
        return $this->range->isInRange($date);
    }
}
