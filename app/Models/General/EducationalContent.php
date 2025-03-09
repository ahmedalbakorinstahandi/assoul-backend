<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalContent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'educational_contents';

    protected $fillable = [
        'title',
        'link',
        'key',
        'order',
        'duration',
        'is_visible',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
    ];
}
