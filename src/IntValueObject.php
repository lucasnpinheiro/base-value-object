<?php

declare(strict_types=1);

namespace BaseValueObject;

/**
 * Class IntValueObject
 * @package ValueObject
 */
abstract class IntValueObject extends ValueObject
{
    /**
     * @var int
     */
    protected int $value;

    /**
     * IntValueObject constructor.
     * @param int $value
     */
    protected function __construct(int $value)
    {
        $this->setValue($value);
    }

    /**
     * @param int $value
     */
    protected function setValue(int $value): void
    {
        if ($this->validate($value)) {
            $this->value = $value;
        }
    }

    /**
     * @param int $value
     * @return bool
     */
    protected function validate(int $value): bool
    {
        return true;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }

    /**
     * @return int
     */
    public function jsonSerialize(): int
    {
        return $this->value();
    }
}