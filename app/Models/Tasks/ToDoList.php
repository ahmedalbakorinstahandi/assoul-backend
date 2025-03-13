<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToDoList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'to_do_list';

    protected $fillable = [
        'title',
        'patient_id',
        'assigned_by',
    ];

    public function patient()
    {
        return $this->belongsTo(\App\Models\Users\Patient::class)->withTrashed();
    }

    public function assignedBy()
    {
        return $this->belongsTo(\App\Models\Users\Guardian::class, 'assigned_by')->withTrashed();
    }

    public function completions()
    {
        return $this->hasMany(ToDoListCompletion::class);
    }
}
