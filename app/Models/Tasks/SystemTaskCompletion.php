<?php

namespace App\Models\Tasks;

use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Model;

class SystemTaskCompletion extends Model
{
    protected $table = 'system_task_completions';

    protected $fillable = [
        'task_id',
        'patient_id',
    ];

    public function task()
    {
        return $this->belongsTo(SystemTask::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
