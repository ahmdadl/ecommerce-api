<?php

namespace Modules\Users\Actions\Profile;

use Illuminate\Support\Facades\Hash;

class UpdatePasswordAction
{
    /**
     * handle action
     */
    public function handle(array $data): void
    {
        $user = user();

        $user->update([
            'password' => Hash::make($data['password']),
        ]);
    }
}
