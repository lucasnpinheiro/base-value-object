<?php

declare(strict_types=1);

namespace BaseValueObject;

/**
 * Class FloatValueObject
 * @package ValueObject
 */
abstract class FloatValueObject extends ValueObject
{
    /**
     * @var float
     */
    protected float $value;

    /**
     * FloatValueObject constructor.
     * @param float $value
     */
    protected function __construct(float $value)
    {
        $this->setValue($value);
    }

    /**
     * @param float $value
     */
    protected function setValue(float $value): void
    {
        if ($this->validate($value)) {
            $this->value = $value;
        }
    }

    /**
     * @param float $value
     * @return bool
     */
    protected function validate(float $value): bool
    {
        return true;
    }

    /**
     * @return float
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value();
    }

    /**
     * @return float
     */
    public function jsonSerialize(): float
    {
        return $this->value();
    }
}
