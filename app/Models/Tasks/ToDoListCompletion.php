<?php

namespace App\Models\Tasks;

use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToDoListCompletion extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

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
        return $this->belongsTo(Patient::class)->withTrashed();
    }
}
