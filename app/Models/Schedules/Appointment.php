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
        'title',
        'appointment_date',
        'status',
        'patient_status',
        'notes',
        'canceled_by',
        'canceled_at',
        'cancel_reason',
    ];

    protected $dates = [
        'appointment_date',
        'deleted_at'
    ];

    protected $casts = [
        'status' => 'string',
        'patient_status' => 'string',
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
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class)->withTrashed();
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class)->withTrashed();
    }
}
