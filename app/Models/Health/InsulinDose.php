<?php

namespace App\Models\Health;

use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Model;

class InsulinDose extends Model
{
    protected $fillable = [
        'patient_id',
        'taken_date',
        'taken_time',
        'insulin_type',
        'dose_units',
        'injection_site'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'taken_date', 'taken_time'];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

   
}
