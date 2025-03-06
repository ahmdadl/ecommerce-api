<?php

use Modules\Users\Enums\UserRole;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;
use Modules\Users\ValueObjects\UserTotals;

it('user_have_columns_by_default', function () {
    $userFactory = User::factory()->customer()->make();

    $user = Customer::create([
        ...$userFactory->only('name', 'email', 'password'),
    ]);

    expect($user->totals)->toBeInstanceOf(UserTotals::class);
    expect($user->role)->toBe(UserRole::CUSTOMER);
    expect($user->is_active)->toBeTrue();
});
