<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToDoListCompletion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'task_id',
        'patient_id',
        'completed_at',
    ];

    public function task()
    {
        return $this->belongsTo(ToDoList::class);
    }

    public function patient()
    {
        return $this->belongsTo(\App\Models\Users\Patient::class)->withTrashed();
    }
}
