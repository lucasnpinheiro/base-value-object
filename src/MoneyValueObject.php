<?php

declare(strict_types=1);

namespace BaseValueObject;

class MoneyValueObject extends NumberValueObject
{
    public static function create(string $value, int $scale): static
    {
        return new static($value, $scale);
    }

}
