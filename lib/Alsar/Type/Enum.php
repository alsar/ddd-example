<?php
namespace Alsar\Type;

abstract class Enum
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * @param mixed $value
     */
    final public function __construct($value)
    {
        $c = new \ReflectionClass($this);

        if(!in_array($value, $c->getConstants())) {
            throw new \InvalidArgumentException("The provided value is not valid.");
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    final public function __toString()
    {
        return $this->value;
    }
}