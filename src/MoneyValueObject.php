<?php

declare(strict_types=1);

namespace BaseValueObject;

use Decimal\Decimal;

/**
 * Class Money
 * @package PicPay\Payments\ValueObject
 */
class MoneyValueObject extends ValueObject
{
    protected int $places = 2;
    protected int $rounding = Decimal::DEFAULT_ROUNDING;
    protected string $currencySymbol = 'R$';

    /**
     * @var Decimal
     */
    private Decimal $decimal;

    /**
     * @param string $value
     */
    protected function __construct(string $value)
    {
        $this->setValue($value);
    }

    /**
     * @param string $value
     * @return static
     */
    public static function create(string $value): self
    {
        return new self($value);
    }

    /**
     * @return $this
     */
    private function createFromDecimal(Decimal $decimal): self
    {
        return new self($decimal->toString());
    }

    /**
     * @param string $value
     */
    private function setValue(string $value)
    {
        $value = empty($value) ? '0' : $value;

        if ($this->validate($value)) {
            $this->decimal = new Decimal($value);
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
     * @param int|null $places
     * @param bool $commas
     * @return string
     */
    public function value(?int $places = null, bool $commas = false): string
    {
        return $this->decimal->toFixed($places ?? $this->places, $commas, $this->rounding);
    }

    /**
     * @return string
     */
    public function rawValue(): string
    {
        return $this->decimal->toString();
    }

    /**
     * @param MoneyValueObject $other
     * @return bool
     */
    public function equals(MoneyValueObject $other): bool
    {
        return $this->decimal->equals($other->decimal);
    }

    /**
     * @param MoneyValueObject $other
     * @return int
     */
    public function compare(MoneyValueObject $other): int
    {
        return $this->decimal->compareTo($other->decimal);
    }

    /**
     * @param MoneyValueObject $other
     * @return bool
     */
    public function greaterThan(MoneyValueObject $other): bool
    {
        return $this->decimal->compareTo($other->decimal) == 1;
    }

    /**
     * @param MoneyValueObject $other
     * @return bool
     */
    public function greaterThanOrEqual(MoneyValueObject $other): bool
    {
        return $this->decimal->compareTo($other->decimal) >= 0;
    }

    /**
     * @return bool
     */
    public function greaterThanZero(): bool
    {
        return $this->greaterThan(MoneyValueObject::create('0'));
    }

    /**
     * @param MoneyValueObject $other
     * @return bool
     */
    public function lessThan(MoneyValueObject $other): bool
    {
        return $this->decimal->compareTo($other->decimal) == -1;
    }

    /**
     * @param MoneyValueObject $other
     * @return bool
     */
    public function lessThanOrEqual(MoneyValueObject $other): bool
    {
        return $this->decimal->compareTo($other->decimal) <= 0;
    }

    /**
     * @param MoneyValueObject $other
     * @return MoneyValueObject
     */
    public function add(MoneyValueObject $other): self
    {
        return $this->createFromDecimal($this->decimal->add($other->decimal));
    }

    /**
     * @param MoneyValueObject $other
     * @return MoneyValueObject
     */
    public function subtract(MoneyValueObject $other): self
    {
        return $this->createFromDecimal($this->decimal->sub($other->decimal));
    }

    /**
     * @param @param float|int|string $multiplier
     * @return MoneyValueObject
     */
    public function multiply($multiplier): MoneyValueObject
    {
        return $this->createFromDecimal($this->decimal->mul($multiplier));
    }

    /**
     * @param @param float|int|string $divisor
     * @return MoneyValueObject
     */
    public function divide($divisor): MoneyValueObject
    {
        return $this->createFromDecimal($this->decimal->div($divisor));
    }

    /**
     * @param MoneyValueObject $other
     * @return MoneyValueObject
     */
    public function multiplyByMoneyValue(MoneyValueObject $other): MoneyValueObject
    {
        return $this->createFromDecimal($this->decimal->mul($other->decimal->toString()));
    }

    /**
     * @param MoneyValueObject $other
     * @return MoneyValueObject
     */
    public function divideByMoneyValue(MoneyValueObject $other): MoneyValueObject
    {
        return $this->createFromDecimal($this->decimal->div($other->decimal->toString()));
    }

    /**
     * @return bool
     */
    public function isZero(): bool
    {
        return $this->decimal->isZero();
    }

    /**
     * @return bool
     */
    public function isPositive(): bool
    {
        return $this->decimal->isPositive();
    }

    /**
     * @return bool
     */
    public function isNegative(): bool
    {
        return $this->decimal->isNegative();
    }

    /**
     * @return string
     */
    public function formatted(): string
    {
        $number = (float) $this->decimal->toFixed(2, false, $this->rounding);

        return sprintf(
            $this->currencySymbol . ' %s',
            number_format($number, 2, ',', '.')
        );
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->value();
    }
}