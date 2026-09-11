<?php

declare(strict_types=1);

namespace Tests\Unit\Features\Common;

use PHPUnit\Framework\TestCase;
use Src\Features\Common\Domain\ValueObjects\Email;
use InvalidArgumentException;

class EmailTest extends TestCase
{
    public function test_creates_valid_email(): void
    {
        $email = Email::fromString('user@example.com');

        $this->assertSame('user@example.com', $email->value());
        $this->assertSame('example.com', $email->domain());
    }

    public function test_normalizes_email_to_lowercase(): void
    {
        $email = Email::fromString('USER@EXAMPLE.COM');

        $this->assertSame('user@example.com', $email->value());
    }

    public function test_throws_on_invalid_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Email::fromString('not-an-email');
    }

    public function test_throws_on_empty_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Email::fromString('');
    }

    public function test_equals_same_email(): void
    {
        $email1 = Email::fromString('user@example.com');
        $email2 = Email::fromString('user@example.com');

        $this->assertTrue($email1->equals($email2));
    }

    public function test_not_equals_different_email(): void
    {
        $email1 = Email::fromString('user@example.com');
        $email2 = Email::fromString('other@example.com');

        $this->assertFalse($email1->equals($email2));
    }

    public function test_to_string_returns_value(): void
    {
        $email = Email::fromString('user@example.com');

        $this->assertSame('user@example.com', (string) $email);
    }
}
