<?php

namespace App\Models\Tasks;

use App\Models\Users\User;
use App\Services\MessageService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Event\Telemetry\System;
use App\Models\Tasks\SystemTaskCompletion;
use App\Models\Users\Patient;

class SystemTask extends Model
{
    protected $table = 'system_tasks';

    protected $fillable = [
        'title',
        'points',
        'image',
        'unique_key',
        'color',
    ];

    protected $dates = ['deleted_at'];

    public function systemTaskCompletion()
    {

        $user = User::auth();

        if (!$user->isPatient()) {
            $patient_id = request()->input('patient_id') ?? request()->query('patient_id');

            $patient = Patient::find($patient_id);

            $user = User::find($patient->user_id);

            if (!$user) {
                abort(
                    response()->json(
                        [
                            'success' => false,
                            'message' => 'الطفل غير محدد',
                            'data' => [],
                        ],
                        404
                    )
                );
            }
        }

        // $patient = User::auth()->patient;

        MessageService::abort(

            200,
            [
                'success' => true,
                'user' => $user->load('patient'),
                'completed_at' => request()->input('completed_at') ?? request()->query('completed_at') ?? now()->toDateString(),
                'system_task' => $this,
                'user_is_patient' => $user->isPatient(),
                'id' => $user->patient->id,
            ]
        );

        $completed_at = request()->input('completed_at') ?? request()->query('completed_at') ?? now()->toDateString();

        return $this->hasOne(SystemTaskCompletion::class, 'task_id', 'id')
            ->whereDate('completed_at', $completed_at)
            ->where('patient_id', $user->patient->id);
    }


    public function getSystemTaskCompletionFirst()
    {
        $completion = $this->systemTaskCompletion;
        return $completion ? $completion->first() : null;
    }


    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => !is_null($value) ? asset("storage/" . $value) : null,
        );
    }
}
