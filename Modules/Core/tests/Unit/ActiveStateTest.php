<?php

namespace Modules\Core\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Users\Models\User;
use Tests\TestCase;

class ActiveStateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_access_active_records(): void
    {
        User::factory(2)->create();
        User::factory(2)->unActive()->create();
        $this->assertEquals(2, User::active()->count());
        $this->assertEquals(2, User::active()->count());
    }

    public function test_can_access_not_active_records(): void
    {
        User::factory(2)->create();
        User::factory(2)->unActive()->create();
        $this->assertEquals(2, User::notActive()->count());
    }

    public function test_can_access_all_records(): void
    {
        User::factory(2)->create();
        User::factory(2)->create();
        $this->assertEquals(4, User::count());
    }
}
