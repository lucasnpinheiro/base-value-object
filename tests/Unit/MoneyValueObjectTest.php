<?php

declare(strict_types=1);

namespace BaseValueObject\Tests\Unit;

use BaseValueObject\MoneyValueObject;
use Decimal\Decimal;
use PHPUnit\Framework\TestCase;

class MoneyValueObjectTest extends TestCase
{
    public function testCreateMoneyValueObject(): void
    {
        $money = MoneyValueObject::create('10.50');
        $this->assertInstanceOf(MoneyValueObject::class, $money);
    }

    public function testValue(): void
    {
        $money = MoneyValueObject::create('10.50');
        $this->assertEquals('10.50', $money->value());
    }

    public function testRawValue(): void
    {
        $money = MoneyValueObject::create('10.50');
        $this->assertEquals('10.50', $money->rawValue());
    }

    public function testEquals(): void
    {
        $money1 = MoneyValueObject::create('10.50');
        $money2 = MoneyValueObject::create('10.50');
        $money3 = MoneyValueObject::create('20.00');

        $this->assertTrue($money1->equals($money2));
        $this->assertFalse($money1->equals($money3));
    }
}