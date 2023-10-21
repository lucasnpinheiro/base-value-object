<?php

declare(strict_types=1);

namespace BaseValueObject;

abstract class StringValueObject extends ValueObject
{
    /**
     * @var string
     */
    protected string $value;

    /**
     * StringValueObject constructor.
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->setValue($value);
    }

    /**
     * @param string $value
     */
    protected function setValue(string $value): void
    {
        if ($this->validate($value)) {
            $this->value = $value;
        }
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function validate(string $value): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->value();
    }
}
