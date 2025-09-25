<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log(string $activity, ?string $details = null)
    {
        ActivityLog::create([
            'activity' => $activity,
            'details'  => $details,
        ]);
    }
}
