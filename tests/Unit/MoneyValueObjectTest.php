<?php

declare(strict_types=1);

namespace BaseValueObject\Tests\Unit;

use BaseValueObject\MoneyValueObject;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MoneyValueObjectTest extends TestCase
{
    public function testConstructorWithValidNumber(): void
    {
        $money = new MoneyValueObject('100.50');
        $this->assertSame('100.50', $money->value());
        $this->assertSame(2, $money->scale);
    }

    public function testConstructorWithInvalidNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new MoneyValueObject('invalid');
    }

    public function testAdd(): void
    {
        $money = new MoneyValueObject('100.50');
        $result = $money->add('50.25');
        $this->assertSame('150.75', $result->value());
    }

    public function testSub(): void
    {
        $money = new MoneyValueObject('100.50');
        $result = $money->sub('50.25');
        $this->assertSame('50.25', $result->value());
    }

    public function testMul(): void
    {
        $money = new MoneyValueObject('10.00');
        $result = $money->mul('2.5');
        $this->assertSame('25.00', $result->value());
    }

    public function testDiv(): void
    {
        $money = new MoneyValueObject('100.00');
        $result = $money->div('4');
        $this->assertSame('25.00', $result->value());
    }

    public function testFloor(): void
    {
        $money = new MoneyValueObject('100.75');
        $result = $money->floor();
        $this->assertSame('100', $result->value());
    }

    public function testCeil(): void
    {
        $money = new MoneyValueObject('100.25');
        $result = $money->ceil();
        $this->assertSame('101', $result->value());
    }

    public function testRound(): void
    {
        $money = new MoneyValueObject('100.255');
        $result = $money->round(2);
        $this->assertSame('100.26', $result->value());
    }

    public function testGt(): void
    {
        $money = new MoneyValueObject('100.50');
        $this->assertTrue($money->gt('50.25'));
    }

    public function testLt(): void
    {
        $money = new MoneyValueObject('50.25');
        $this->assertTrue($money->lt('100.50'));
    }

    public function testGte(): void
    {
        $money = new MoneyValueObject('100.50');
        $this->assertTrue($money->gte('100.50'));
        $this->assertTrue($money->gte('50.25'));
    }

    public function testLte(): void
    {
        $money = new MoneyValueObject('100.50');
        $this->assertTrue($money->lte('100.50'));
        $this->assertTrue($money->lte('150.75'));
    }

    public function testEq(): void
    {
        $money = new MoneyValueObject('100.50');
        $this->assertTrue($money->eq('100.50'));
        $this->assertFalse($money->eq('150.75'));
    }

    public function testToFloat(): void
    {
        $money = new MoneyValueObject('100.50');
        $this->assertSame(100.50, $money->toFloat());
    }

    public function testFormat(): void
    {
        $money = new MoneyValueObject('12345.678');
        $formatted = $money->format(2, ',', '.');
        $this->assertSame('12.345,68', $formatted);
    }


    public function testMod(): void
    {
        $money = new MoneyValueObject('100');
        $result = $money->mod('3');
        $this->assertSame('1', $result->value());
    }
}