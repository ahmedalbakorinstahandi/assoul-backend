<?php

namespace App\Models\Health;

use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BloodSugarReading extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'measurement_type',
        'value',
        'unit',
        'notes',
        'measured_at',
        'measurementable_id',
        'measurementable_type',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }
}
