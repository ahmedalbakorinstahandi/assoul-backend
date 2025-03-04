<?php

namespace App\Models\Health;

use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Model;

class PhysicalActivity extends Model
{
    protected $table = 'physical_activities';
    protected $fillable = [
        'patient_id',
        'activity_date',
        'activity_time',
        'description',
        'intensity',
        'duration',
        'notes',
    ];

    protected $dates = ['activity_date', 'created_at', 'updated_at', 'deleted_at'];


    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }
}
