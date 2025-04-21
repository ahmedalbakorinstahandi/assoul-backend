<?php

namespace App\Http\Permissions\Tasks;

use App\Models\Users\User;
use App\Services\MessageService;

class ToDoListPermission
{

    public static function index($query)
    {

        $user = User::auth();

        if ($user->isPatient()) {
            $query->where('patient_id', $user->patient->id);
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            $query->orWhereIn('patient_id', $childrenIds);
        }

        return $query;
    }

    public static function show($task)
    {
        $user = User::auth();

        if ($user->isPatient() && $task->patient_id != $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بالوصول إلى هذه المهمة');
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($task->patient_id, $childrenIds)) {
                MessageService::abort(403, 'غير مسموح لك بالوصول إلى هذه المهمة');
            }
        }
    }

    public static function create($data)
    {
        $user = User::auth();

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($data['patient_id'], $childrenIds)) {
                MessageService::abort(403, 'غير مسموح لك بإضافة البيانات لهذا الطفل');
            }
        }

        $data['assigned_by'] = $user->guardian->id;

        return $data;
    }

    public static function update($task)
    {
        $user = User::auth();

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($task->patient_id, $childrenIds)) {
                abort(403, 'غير مسموح لك بتعديل هذه المهمة');
            }
        }
    }

    public static function delete($task)
    {
        $user = User::auth();

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($task->patient_id, $childrenIds)) {
                abort(403, 'غير مسموح لك بحذف هذه المهمة');
            }
        }
    }


    public static function check($task)
    {

        $user = User::auth();

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($task->patient_id, $childrenIds)) {
                MessageService::abort(403, 'غير مسموح لك بتعديل حالة هذه المهمة');
            }
        }


        if ($user->isPatient()) {
            $patient = User::auth()->patient;
            if ($patient->id != $task->patient_id) {
                MessageService::abort(403, 'غير مسموح لك بتعديل حالة هذه المهمة');
            }
        }
    }
}
