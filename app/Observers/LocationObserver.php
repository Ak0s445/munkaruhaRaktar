<?php

namespace App\Observers;

use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LocationObserver
{
    public function created(Location $location): void
    {
        Log::channel('location')->info('create', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'location_id' => $location->id,
        ]);
    }

    public function updated(Location $location): void
    {
        Log::channel('location')->info('update', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'location_id' => $location->id,
            'changed' => array_keys($location->getChanges()),
        ]);
    }

    public function deleted(Location $location): void
    {
        Log::channel('location')->info('delete', [
            'actor_user_id' => Auth::id(),
            'actor_role' => Auth::user()?->role,
            'location_id' => $location->id,
        ]);
    }
}
