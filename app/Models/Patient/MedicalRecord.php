<?php

namespace App\Models\Patient;

use App\Models\Users\Patient;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'title',
        'description',
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
