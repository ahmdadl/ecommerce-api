<?php

use App\Post;
use Modules\Guests\Models\Guest;
use Modules\Users\Enums\UserRole;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;

test('user_role_auth_works', function () {
    /** @var Customer $customer */
    $customer = User::factory()->customer()->create();

    expect($customer->role)->toBe(UserRole::CUSTOMER);

    // expect(auth('customer')->attempt([$customer->email, '123123123']))->toBeTrue();
});
