<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class ChildrenGuardian extends Model
{
    protected $table = 'children_guardians';
    protected $fillable = ['guardian_id', 'child_id'];

    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    public function children()
    {
        return $this->hasMany(Patient::class, 'patient_id');
    }
}
