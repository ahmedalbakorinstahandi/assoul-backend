<?php

namespace App\Models\Games;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Users\Patient;

class PatientAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'answer_id',
        'question_id',
        'custom_answer',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class)->withTrashed();
    }
}
