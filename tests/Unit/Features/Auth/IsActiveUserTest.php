<?php

declare(strict_types=1);

namespace Tests\Unit\Features\Auth;

use PHPUnit\Framework\TestCase;
use Src\Features\Auth\Domain\Rules\IsActiveUser;

class IsActiveUserTest extends TestCase
{
    private IsActiveUser $rule;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rule = new IsActiveUser();
    }

    public function test_active_user_is_allowed(): void
    {
        $result = $this->rule->check([
            'is_active' => true,
            'deleted_at' => null,
        ]);

        $this->assertTrue($result['allowed']);
    }

    public function test_inactive_user_is_denied(): void
    {
        $result = $this->rule->check([
            'is_active' => false,
            'deleted_at' => null,
        ]);

        $this->assertFalse($result['allowed']);
        $this->assertNotEmpty($result['reason']);
    }

    public function test_soft_deleted_user_is_denied(): void
    {
        $result = $this->rule->check([
            'is_active' => true,
            'deleted_at' => '2026-01-01 00:00:00',
        ]);

        $this->assertFalse($result['allowed']);
    }

    public function test_missing_is_active_is_denied(): void
    {
        $result = $this->rule->check([
            'deleted_at' => null,
        ]);

        $this->assertFalse($result['allowed']);
    }
}
