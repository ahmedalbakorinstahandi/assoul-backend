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
        'completed_at',
    ];

    public $timestamps = false;

    public function task()
    {
        return $this->belongsTo(SystemTask::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}


//ALTER TABLE `system_task_completions` ADD `completed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `patient_id`;