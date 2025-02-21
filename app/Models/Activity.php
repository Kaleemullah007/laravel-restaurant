<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'edits' => 'collection',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The fields which can't be mass-assigned.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * We don't use both of the default 'created_at' and 'updated_at' fields.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the after value of an edit.
     *
     * @param  string  $field
     * @return string
     */
    public function after($field)
    {
        return $this->edits[$field][1];
    }

    /**
     * Get the before value of an edit.
     *
     * @param  string  $field
     * @return string
     */
    public function before($field)
    {
        return $this->edits[$field][0];
    }

    /**
     * Relationship with the Model this activity is tracking.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * Relationship with User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function user()
    {
        return $this->morphTo();
    }
}
