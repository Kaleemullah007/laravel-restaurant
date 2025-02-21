<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;

trait FilterByUser
{
    public static function boot()
    {
        parent::boot();

        self::addGlobalScope(function (Builder $builder) {
            $table = $builder->getQuery()->from;
            $role = 'vendor';
            if (auth()->check()) {
                $user = auth()->user();

                if ($user->user_type == 'vendor') {
                    $builder->where("{$table}.owner_id", auth()->user()->owner_id ?? 1);
                } elseif ($user->user_type == 'employee') {
                    $builder->where("{$table}.owner_id", auth()->user()->owner_id);
                } elseif ($user->user_type == 'admin') {
                    $builder->where("{$table}.owner_id", auth()->user()->id);
                } elseif ($user->user_type == 'superadmin') {
                    // It'll show all record
                    if (session()->has('admin_id')) {
                        $builder->where("{$table}.owner_id", session()->get('admin_id'));
                    } else {
                        // $builder->where('is_tester',false);
                    }

                    // dd(session()->all());
                }
            }
        });
    }
}
