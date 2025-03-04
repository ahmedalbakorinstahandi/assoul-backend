<?php

namespace App\Models\Health;

use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhysicalActivity extends Model
{
    use HasFactory, SoftDeletes;

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
