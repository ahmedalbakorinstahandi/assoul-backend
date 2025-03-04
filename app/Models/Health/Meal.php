<?php

namespace App\Models\Health;

use App\Models\Users\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'consumed_date',
        'type',
        'carbohydrates_calories',
        'description',
        'notes',
    ];

    protected $dates = ['consumed_date', 'created_at', 'updated_at', 'deleted_at'];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }
}
