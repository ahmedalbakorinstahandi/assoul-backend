<?php

namespace App\Models\Tasks;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        $patient = User::auth()->patient;
        return $this->hasOne(SystemTaskCompletion::class, 'task_id', 'id')
            ->whereDate('created_at', now()->toDateString())
            ->where('patient_id', $patient->id);
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
