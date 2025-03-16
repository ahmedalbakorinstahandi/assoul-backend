<?php

namespace App\Models\Schedules;

use App\Models\Users\Doctor;
use App\Models\Users\Guardian;
use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'guardian_id',
        'doctor_id',
        'appointment_date',
        'status',
        'patient_status',
        'notes'
    ];

    protected $dates = [
        'appointment_date',
        'deleted_at'
    ];

    protected $casts = [
        'status' => 'boolean',
        'patient_status' => 'boolean',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'appointment_date' => 'datetime',
        'patient_id' => 'integer',
        'guardian_id' => 'integer',
        'doctor_id' => 'integer',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
