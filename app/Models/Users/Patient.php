<?php

namespace App\Models\Users;

use App\Models\Health\BloodSugarReading;
use App\Models\Patient\Instruction;
use App\Models\Patient\MedicalRecord;
use App\Models\Patient\PatientNote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'gender',
        'birth_date',
        'height',
        'weight',
        'insulin_doses',
        'points',
        'diabetes_diagnosis_age'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'date_of_birth'];

    public function isChild()
    {
        return true;
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class);
    }

    public function notes()
    {
        return $this->hasMany(PatientNote::class);
    }

    public function guardian()
    {
        return $this->belongsToMany(
            Guardian::class,
            ChildrenGuardian::class,
            'patient_id',
            'guardian_id'
        )->withTrashed();
    }

    public function childrenGuardian()
    {
        return $this->hasMany(ChildrenGuardian::class);
    }

    public function bloodSugarReadings()
    {
        return $this->hasMany(BloodSugarReading::class);
    }
}
