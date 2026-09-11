<?php

declare(strict_types=1);

namespace Src\Features\Common\Domain\ValueObjects;

use InvalidArgumentException;

/**
 * Représente un montant monétaire en FCFA (XOF).
 * Les montants sont stockés en centimes (integer) pour éviter les erreurs flottantes.
 */
final class Money
{
    private function __construct(
        private readonly int $amountInCents,
        private readonly string $currency = 'XOF',
    ) {
        if ($amountInCents < 0) {
            throw new InvalidArgumentException('Le montant ne peut pas être négatif.');
        }
    }

    public static function fromCents(int $cents, string $currency = 'XOF'): self
    {
        return new self($cents, $currency);
    }

    public static function fromAmount(float $amount, string $currency = 'XOF'): self
    {
        return new self((int) round($amount * 100), $currency);
    }

    public static function fromFrancs(int $francs, string $currency = 'XOF'): self
    {
        return new self($francs * 100, $currency);
    }

    public static function zero(string $currency = 'XOF'): self
    {
        return new self(0, $currency);
    }

    public function amountInCents(): int
    {
        return $this->amountInCents;
    }

    public function amount(): float
    {
        return $this->amountInCents / 100;
    }

    public function francs(): int
    {
        return (int) ($this->amountInCents / 100);
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function add(self $other): self
    {
        $this->assertSameCurrency($other);
        return new self($this->amountInCents + $other->amountInCents, $this->currency);
    }

    public function subtract(self $other): self
    {
        $this->assertSameCurrency($other);
        return new self($this->amountInCents - $other->amountInCents, $this->currency);
    }

    public function multiply(int $factor): self
    {
        return new self($this->amountInCents * $factor, $this->currency);
    }

    public function percentage(float $percent): self
    {
        return new self((int) round($this->amountInCents * $percent / 100), $this->currency);
    }

    public function isGreaterThan(self $other): bool
    {
        $this->assertSameCurrency($other);
        return $this->amountInCents > $other->amountInCents;
    }

    public function isLessThan(self $other): bool
    {
        $this->assertSameCurrency($other);
        return $this->amountInCents < $other->amountInCents;
    }

    public function equals(self $other): bool
    {
        return $this->amountInCents === $other->amountInCents
            && $this->currency === $other->currency;
    }

    public function isZero(): bool
    {
        return $this->amountInCents === 0;
    }

    public function formatted(): string
    {
        return number_format($this->francs(), 0, ',', ' ') . ' ' . $this->currency;
    }

    private function assertSameCurrency(self $other): void
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException(
                "Incompatibilité de devise : {$this->currency} vs {$other->currency}"
            );
        }
    }

    public function __toString(): string
    {
        return $this->formatted();
    }
}
