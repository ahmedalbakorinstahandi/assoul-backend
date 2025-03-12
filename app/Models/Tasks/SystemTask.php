<?php

namespace App\Models\Tasks;

use Illuminate\Database\Eloquent\Model;

class SystemTask extends Model
{
    protected $table = 'system_tasks';

    protected $fillable = [
        'title',
        'points',
        'image',
        'unique_key'
    ];

    protected $dates = ['deleted_at'];

    public function systemTaskCompletion()
    {
        return $this->hasMany(SystemTaskCompletion::class, 'task_id', 'id');
    }
}
