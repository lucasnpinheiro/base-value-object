<?php

declare(strict_types=1);

namespace BaseValueObject;

/**
 * Class BooleanValueObject
 * @package ValueObject
 */
abstract class BooleanValueObject extends ValueObject
{
    /**
     * @var bool
     */
    protected bool $value;

    /**
     * BooleanValueObject constructor.
     * @param bool $value
     */
    protected function __construct(bool $value)
    {
        $this->setValue($value);
    }

    /**
     * @param bool $value
     */
    protected function setValue(bool $value): void
    {
        if ($this->validate($value)) {
            $this->value = $value;
        }
    }

    /**
     * @param bool $value
     * @return bool
     */
    protected function validate(bool $value): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function value(): bool
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value ? 'true' : 'false';
    }

    /**
     * @return bool
     */
    public function jsonSerialize(): bool
    {
        return $this->value();
    }
}