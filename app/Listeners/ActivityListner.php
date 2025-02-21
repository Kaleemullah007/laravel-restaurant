<?php

namespace App\Listeners;

use App\Events\ActivityEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityListner
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(ActivityEvent $event)
    {
        $event->model->exists ?
            $this->recordActivity($event->model) :
            $event->model->modelActivities()->delete();
    }

    /**
     * Record all activity that has ocurred including soft deletes.
     *
     * @return void
     */
    private function recordActivity($model)
    {
        if (! $model->wasRecentlyCreated && ! $model->wasChanged()) {
            return;
        }

        Activity::create([
            'action' => $model->deleted_at !== null ? 'deleted' : (
                $model->wasChanged() ? 'updated' : 'created'
            ),
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'user_type' => Auth::check() ? get_class(Auth::user()) : null,
            'model_id' => $model->id,
            'model_type' => get_class($model),
            'edits' => $model->wasChanged() ?
                collect($model->getOriginal())
                    ->diffAssoc(collect($model->getAttributes()))
                    ->forget('updated_at')
                    ->map(fn ($val, $key) => [$val, $model->$key]) :
                collect([]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
