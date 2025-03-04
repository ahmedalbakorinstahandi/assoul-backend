<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function children()
    {
        return $this->hasManyThrough(
            Patient::class,
            ChildrenGuardian::class,
            'guardian_id',
            'id',
            'id',
            'patient_id'
        )->withTrashed();
    }
}