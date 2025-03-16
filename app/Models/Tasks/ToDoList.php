<?php

namespace App\Models\Tasks;

use App\Models\Users\Guardian;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\MessageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToDoList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'to_do_list';

    protected $fillable = [
        'title',
        'patient_id',
        'assigned_by',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }

    public function assignedBy()
    {
        return $this->belongsTo(Guardian::class, 'assigned_by')->withTrashed();
    }

    public function completion()
    {
        $user = User::auth();

        if ($user->isPatient()) {
            $patient = $user->patient;
        } else {
            $patient_id = request()->input('patient_id') ?? request()->query('patient_id');

            $user = User::find($patient_id);

            if (!$user) {
                MessageService::abort(404, 'الطفل غير محدد');
            }

            $patient = $user->patient;
        }

        $createdAt = request()->input('completed_at') ?? request()->query('completed_at') ?? now()->toDateString();
        return $this->hasOne(ToDoListCompletion::class, 'task_id', 'id')
            ->whereDate('completed_at', $createdAt)
            ->where('patient_id', $patient->id);
    }
}
