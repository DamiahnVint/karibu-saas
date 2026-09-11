<?php

declare(strict_types=1);

namespace Tests\Unit\Features\Common;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Src\Features\Common\Domain\ValueObjects\Money;

class MoneyTest extends TestCase
{
    public function test_creates_from_francs(): void
    {
        $money = Money::fromFrancs(25000);

        $this->assertSame(2500000, $money->amountInCents());
        $this->assertSame(25000, $money->francs());
    }

    public function test_creates_zero(): void
    {
        $money = Money::zero();

        $this->assertTrue($money->isZero());
        $this->assertSame(0, $money->amountInCents());
    }

    public function test_adds_money(): void
    {
        $a = Money::fromFrancs(10000);
        $b = Money::fromFrancs(15000);

        $result = $a->add($b);

        $this->assertSame(25000, $result->francs());
    }

    public function test_subtracts_money(): void
    {
        $a = Money::fromFrancs(25000);
        $b = Money::fromFrancs(10000);

        $result = $a->subtract($b);

        $this->assertSame(15000, $result->francs());
    }

    public function test_multiplies(): void
    {
        $money = Money::fromFrancs(5000);

        $result = $money->multiply(3);

        $this->assertSame(15000, $result->francs());
    }

    public function test_calculates_percentage(): void
    {
        $salary = Money::fromFrancs(500000);
        $rate = 7.70;

        $cots = $salary->percentage($rate);

        $this->assertSame(38500, $cots->francs());
    }

    public function test_formats_correctly(): void
    {
        $money = Money::fromFrancs(25000);

        $this->assertSame('25 000 XOF', $money->formatted());
    }

    public function test_is_greater_than(): void
    {
        $a = Money::fromFrancs(50000);
        $b = Money::fromFrancs(25000);

        $this->assertTrue($a->isGreaterThan($b));
        $this->assertFalse($b->isGreaterThan($a));
    }

    public function test_throws_on_negative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Money::fromCents(-100);
    }

    public function test_throws_on_currency_mismatch(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $xof = Money::fromFrancs(1000, 'XOF');
        $eur = Money::fromFrancs(100, 'EUR');
        $xof->add($eur);
    }
}
