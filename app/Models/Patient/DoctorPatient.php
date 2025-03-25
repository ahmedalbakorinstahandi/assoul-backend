<?php

namespace App\Models\Patient;

use App\Models\Users\Doctor;
use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoctorPatient extends Model
{
    use SoftDeletes;

    protected $table = 'doctor_patients';

    protected $fillable = [
        'doctor_id',
        'patient_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
