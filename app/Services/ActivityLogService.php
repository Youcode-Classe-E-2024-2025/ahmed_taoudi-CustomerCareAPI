<?php

namespace App\Services;

use App\Models\ActivityLog; 
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Log a new activity.
     *
     * @param string $action
     * @param string $description
     * @param string $subjectType
     * @param string $subjectId
     * @return \App\Models\ActivityLog
     */
    public function log(string $action, string $description, string $subjectType, string $subjectId)
    {

        return ActivityLog::create([
            'user_id' => Auth::id(), 
            'action' => $action, 
            'description' => $description, 
            'subject_type' => $subjectType,
            'subject_id' => $subjectId, 
        ]);
    }
}
