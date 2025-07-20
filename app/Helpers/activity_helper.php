<?php

use App\Models\ActivityLogModel;

function log_activity($activity)
{
    $userId = session('user_id');
    $logModel = new ActivityLogModel();

    $logModel->insert([
        'user_id'  => $userId ?? 0,
        'activity' => $activity,
    ]);
}
