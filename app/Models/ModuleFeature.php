<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ModuleFeature extends Pivot
{
    use HasFactory;

    protected $table = 'module_features';

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class)->withTimestamps();

    }
}
