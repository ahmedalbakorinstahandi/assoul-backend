<?php

namespace App\Http\Permissions\Tasks;

use App\Models\Users\User;
use App\Services\MessageService;
use GuzzleHttp\Psr7\Message;

class SystemTaskPermission
{
    public static function taskSTatus($task)
    {
        $user = User::auth();

        if (!$user->isPatient()) {
            MessageService::abort(403, 'غير مصرح لك بتغيير حالة المهمة');
        }

        if ($task->systemTaskCompletion->patient_id != $user->patient->id) {
            MessageService::abort(403, 'غير مصرح لك بتغيير حالة المهمة');
        }
    }
}
