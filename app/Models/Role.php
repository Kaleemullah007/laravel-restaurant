<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    public $timestamps = true;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @return bool
     */
    public function hasPermission(Permission $permission, User $user)
    {
        return $this->hasRole($permission->roles);
    }

    /**
     * Determine if the role has the given permission.
     *
     * @param  mixed  $permission
     * @return bool
     */
    public function inRole($permission)
    {
        if (is_string($permission)) {
            return $this->permissions->contains('name', $permission);
        }

        return (bool) $permission->intersect($this->permissions)->count();
    }
}
