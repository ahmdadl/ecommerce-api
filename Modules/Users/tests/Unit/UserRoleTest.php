<?php

use Modules\Users\Enums\UserRole;
use Modules\Users\Models\Admin;
use Modules\Users\Models\Customer;
use Modules\Users\Models\User;

test('user_role_auth_works', function () {
    /** @var Customer $customer */
    $customer = User::factory()->customer()->create();

    expect($customer->role)->toBe(UserRole::CUSTOMER);

    $credentials = [
        'email' => $customer->email,
        'password' => '123123123',
    ];

    expect(Customer::attempt($credentials))->toBeTrue();
    expect(Admin::attempt($credentials))->toBeFalse();
});
