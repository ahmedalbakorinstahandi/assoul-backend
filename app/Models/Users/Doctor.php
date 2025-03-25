<?php

namespace App\Models\Users;

use App\Models\Patient\DoctorPatient;
use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'specialization',
        'classification_number',
        'workplace_clinic_location',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function doctorPatients()
    {
        return $this->hasMany(DoctorPatient::class);
    }
}
