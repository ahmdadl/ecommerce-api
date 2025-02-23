<?php

namespace Modules\Users\Traits;

trait RoleCheck
{
    /**
     * Retrieve a user by their credentials, ensuring they have the correct role.
     *
     * @param array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        // Retrieve the user by credentials
        $user = parent::retrieveByCredentials($credentials);

        // Check if the user has the correct role
        if ($user && $user->role === $this->role) {
            return $user;
        }

        return null;
    }

    /**
     * Scope a query to only include users with the specified role.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRole($query)
    {
        return $query->where('role', $this->role);
    }
}
