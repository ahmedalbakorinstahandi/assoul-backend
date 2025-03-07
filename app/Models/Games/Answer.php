<?php

namespace App\Models\Games;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
        'image',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class)->withTrashed();
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => !is_null($value) ? asset("storage/" . $value) : null,
        );
    }
}
