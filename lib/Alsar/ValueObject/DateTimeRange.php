<?php
namespace Alsar\ValueObject;

use Assert\Assertion;
use DateTimeImmutable;

class DateTimeRange
{
    /**
     * @var DateTimeImmutable
     */
    protected $start;

    /**
     * @var DateTimeImmutable
     */
    protected $end;

    /**
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     */
    public function __construct(DateTimeImmutable $start, DateTimeImmutable $end)
    {
        Assertion::true($start < $end);

        $this->start = $start;
        $this->end   = $end;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param DateTimeImmutable $date
     *
     * @return boolean
     */
    public function isInRange(DateTimeImmutable $date)
    {
        return $date >= $this->start && $date <= $this->end;
    }

    /**
     * TODO: error checking
     *
     * @param string $stringDateRange
     *
     * @return DateTimeRange
     */
    public static function parse($stringDateRange)
    {
        Assertion::string($stringDateRange);

        list($start, $end) = explode(' - ', $value, 2);

        return new self(new \DateTimeImmutable($start), new \DateTimeImmutable($end));
    }

    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->start->format('Y-m-d H:i:s'),
            $this->end->format('Y-m-d H:i:s')
        );
    }
}
