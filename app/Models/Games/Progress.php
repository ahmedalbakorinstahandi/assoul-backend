<?php

namespace App\Models\Games;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Users\Patient;

class Progress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'patient_id',
        'game_id',
        'level_id',
        'question_id',
        'points',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function game()
    {
        return $this->belongsTo(Game::class)->withTrashed();
    }

    public function level()
    {
        return $this->belongsTo(Level::class)->withTrashed();
    }
}
