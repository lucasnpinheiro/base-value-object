<?php

declare(strict_types=1);

namespace BaseValueObject;

use InvalidArgumentException;
use Stringable;

abstract class NumberValueObject implements Stringable
{
    public readonly string $value;
    public readonly int $scale;

    public function __construct(string|int $num, ?int $scale = null)
    {
        if (!is_numeric($num)) {
            throw new InvalidArgumentException('Invalid number');
        }

        $this->value = (string)$num;
        $this->scale = $scale ?? $this->calculateScale($this->value);

        if ($this->scale < 0) {
            throw new InvalidArgumentException('Scale must be greater than or equal to 0');
        }
    }

    private function calculateScale(string $value): int
    {
        $decimalPosition = strpos($value, '.');
        return $decimalPosition === false ? 0 : strlen($value) - $decimalPosition - 1;
    }

    public function add(NumberValueObject|string|int $num, ?int $scale = null): static
    {
        return $this->calculate('add', $num, $scale);
    }

    public function sub(NumberValueObject|string|int $num, ?int $scale = null): static
    {
        return $this->calculate('sub', $num, $scale);
    }

    public function mul(NumberValueObject|string|int $num, ?int $scale = null): static
    {
        return $this->calculate('mul', $num, $scale);
    }

    public function div(NumberValueObject|string|int $num, ?int $scale = null): static
    {
        return $this->calculate('div', $num, $scale);
    }

    public function mod(NumberValueObject|string|int $num): static
    {
        return $this->calculate('mod', $num, null);
    }

    private function calculate(string $operation, NumberValueObject|string|int $num, ?int $scale = null): static
    {
        $scale = $scale ?? $this->scale;
        $numValue = (string)($num instanceof NumberValueObject ? $num->value : $num);

        $result = match ($operation) {
            'add' => bcadd($this->value, $numValue, $scale),
            'sub' => bcsub($this->value, $numValue, $scale),
            'mul' => bcmul($this->value, $numValue, $scale),
            'div' => bcdiv($this->value, $numValue, $scale),
            'mod' => bcmod($this->value, $numValue),
            default => throw new InvalidArgumentException('Invalid operation'),
        };

        return $this->create($result, $scale);
    }

    abstract public static function create(string $value, int $scale): static;

    public function floor(): static
    {
        return $this->create(bcadd($this->value, '0', 0), 0);
    }

    public function ceil(): static
    {
        if ($this->eq(bcadd($this->value, '0', 0))) {
            return $this;
        }
        return $this->create(bcadd($this->value, '1', 0), 0);
    }

    public function round(int $precision = 0): static
    {
        $factor = bcpow('10', (string)$precision);
        $scaled = bcmul($this->value, $factor, $precision + 1);
        $adjustment = $scaled[0] === '-' ? '-0.5' : '0.5';
        $rounded = bcadd($scaled, $adjustment, 0);
        return $this->create(bcdiv($rounded, $factor, $precision), $precision);
    }

    public function gte(NumberValueObject|string|int $num, ?int $scale = null): bool
    {
        return !$this->lt($num, $scale);
    }

    public function lt(NumberValueObject|string|int $num, ?int $scale = null): bool
    {
        return $this->compare($num, $scale) === -1;
    }

    public function lte(NumberValueObject|string|int $num, ?int $scale = null): bool
    {
        return !$this->gt($num, $scale);
    }

    public function gt(NumberValueObject|string|int $num, ?int $scale = null): bool
    {
        return $this->compare($num, $scale) === 1;
    }

    public function eq(NumberValueObject|string|int $num, ?int $scale = null): bool
    {
        return $this->compare($num, $scale) === 0;
    }

    public function equals(NumberValueObject|string|int $num): bool
    {
        return $this->eq($num);
    }

    private function compare(NumberValueObject|string|int $num, ?int $scale = null): int
    {
        $numValue = (string)($num instanceof NumberValueObject ? $num->value : $num);
        return bccomp($this->value, $numValue, $scale ?? $this->scale);
    }

    public function format(
        ?int $scale = null,
        string $decimalSeparator = '.',
        string $thousandsSeparator = ''
    ): string {
        return number_format((float)$this->value, $scale ?? $this->scale, $decimalSeparator, $thousandsSeparator);
    }

    public function toFloat(): float
    {
        return (float)$this->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }
}
