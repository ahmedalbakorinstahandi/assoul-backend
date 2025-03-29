<?php

namespace App\Models\Tasks;

use App\Models\Users\User;
use App\Services\MessageService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Event\Telemetry\System;

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

        if ($user->isPatient()) {
            $patient = $user->patient;
        } else {
            $patient_id = request()->input('patient_id') ?? request()->query('patient_id');

            $user = User::find($patient_id);

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


            $patient = $user->patient;
        }

        // $patient = User::auth()->patient;

        $createdAt = request()->input('completed_at') ?? request()->query('completed_at') ?? now()->toDateString();

        // return $this->hasOne(SystemTaskCompletion::class, 'task_id', 'id')
        //     ->whereDate('completed_at', $createdAt)
        //     ->where('patient_id', $patient->id);


        $systemTaskCompletion = SystemTaskCompletion::where('task_id', $this->id)
            ->where('patient_id', $patient->id)
            ->whereDate('completed_at', $createdAt)
            ->orderBy('created_at', 'desc')
            ->get()->first();

        return $systemTaskCompletion;
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
