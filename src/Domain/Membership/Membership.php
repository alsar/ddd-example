<?php
namespace Alsar\Ddd\Domain\Membership;

use Alsar\Clock\Clock;
use Alsar\Ddd\Domain\Membership\Package\Package;
use Alsar\Exception\MethodNotImplementedException;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Membership
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Collection|Period[]
     */
    protected $periods;

    /**
     * @var Clock
     */
    protected $clock;

    /**
     * @param Package $package
     * @param Clock   $clock
     */
    public function __construct(Package $package, Clock $clock)
    {
        $this->clock = $clock;
        $this->periods = new ArrayCollection();

        $period = new Period($clock->getCurrentDate(), $package);
        $this->periods->add($period);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Clock $clock
     */
    public function setClock(Clock $clock)
    {
        $this->clock = $clock;
    }

    /**
     * @param Package $package
     */
    public function extend(Package $package)
    {
        $latestPeriod = $this->periods->first();

        foreach ($this->periods as $period) {
            if ($period->getEnd() > $latestPeriod->getEnd()) {
                $latestPeriod = $period;
            }
        }

        $start = $latestPeriod->getEnd();
        $currentDate = $this->clock->getCurrentDate();

        if ($start < $currentDate) {
            $start = $currentDate;
        }

        $newPeriod = new Period($start, $package);

        $this->periods->add($newPeriod);
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->getValidUntil() > $this->clock->getCurrentDate();
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return !$this->isValid();
    }

    /**
     * TODO: preimenovati??
     * TODO: ali se sploh rabi??
     *
     * @return DateTimeImmutable
     */
    public function getEnd()
    {
        return $this->getLatestPeriod()->getEnd();
    }

    /**
     * @return Period
     */
    public function getLatestPeriod()
    {
        $latestPeriod = $this->periods->first();

        foreach ($this->periods as $period) {
            if ($period->getEnd() > $latestPeriod->getEnd()) {
                $latestPeriod = $period;
            }
        }

        return $latestPeriod;
    }

    /**
     * @return Period|null
     */
    public function getCurrentPeriod()
    {
        $currentDate = $this->clock->getCurrentDate();

        foreach ($this->periods as $period) {
            if ($period->isInRange($currentDate)) {
                return $period;
            }
        }

        return null;
    }

    /**
     * @return Period
     */
    public function getFuturePeriods()
    {
        throw new MethodNotImplementedException();
    }

    /**
     * @return Collection|Period[]
     */
    public function getPeriods()
    {
        return $this->periods;
    }
}
