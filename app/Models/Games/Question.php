<?php

namespace App\Models\Games;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'level_id',
        'text',
        'image',
        'points',
        'type',
        'answers_view',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class)->withTrashed();
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function patientAnswers()
    {
        return $this->hasMany(PatientAnswer::class);
    }

    public function progresses()
    {
        return $this->hasMany(Progress::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => !is_null($value) ? asset("storage/" . $value) : null,
        );
    }
}
