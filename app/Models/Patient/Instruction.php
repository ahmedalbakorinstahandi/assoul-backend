<?php

namespace App\Models\Patient;

use App\Models\Users\Patient;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    protected $fillable = [
        'content',
        'patient_id',
        'added_by',
    ];

    protected $casts = [
        'content' => 'string',
        'patient_id' => 'integer',
        'added_by' => 'integer',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
