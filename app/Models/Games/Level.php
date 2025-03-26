<?php

namespace App\Models\Games;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'game_id',
        'title',
        'number',
        'status',
    ];


    public function game()
    {
        return $this->belongsTo(Game::class)->withTrashed();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }


    public function canPublish()
    {
        //if question type is MCQ we have 4 answers for each question to be published
        //if question type is DragDrop we have 2 answers for each question to be published
        // if question type is LetterArrangement we have 1 answer for each question to be published


        $questions = $this->questions()->get();

        foreach ($questions as $question) {
            if ($question->type == 'MCQ') {
                if ($question->answers()->count() < 4) {
                    return false;
                }
            } elseif ($question->type == 'DragDrop') {
                if ($question->answers()->count() < 2) {
                    return false;
                }
            } elseif ($question->type == 'LetterArrangement') {
                if ($question->answers()->count() < 1) {
                    return false;
                }
            }
        }

        return true;
    }

    // // progress
    // public function getChildLevelStatus()
    // {
    //     $user = User::auth();

    //     if (!$user->isPatient()) {
    //         return null;
    //     }

    //     $patientId = $user->patient->id;

    //     // جلب عدد الأسئلة في المستوى
    //     $questionCount = $this->questions()->count();

    //     // جلب عدد الأسئلة التي تم التقدم فيها
    //     $progressCount = $this->progress()->where('patient_id', $patientId)->distinct('question_id')->count();

    //     // الحالة: `completed` إذا تم الإجابة على جميع الأسئلة
    //     if ($progressCount == $questionCount) {
    //         return 'completed';
    //     }

    //     // الحالة: `in_progress` إذا تم الإجابة على بعض الأسئلة
    //     if ($progressCount > 0) {
    //         return 'in_progress';
    //     }

    //     // جلب المستوى السابق
    //     $previousLevel = Level::where('game_id', $this->game_id)
    //         ->where('order', '<', $this->order)
    //         ->orderBy('order', 'desc')
    //         ->first();

    //     // إذا لم يكن هناك مستوى سابق أو كان المستوى السابق مكتملًا، فهو `unlocked`
    //     if (!$previousLevel || $previousLevel->getChildLevelStatus() == 'completed') {
    //         return 'unlocked';
    //     }

    //     // إذا لم يتحقق أي شرط، فالمستوى مغلق `locked`
    //     return 'locked';
    // }

    public function getChildLevelStatus()
    {
        $user = User::auth();

        if (!$user->isPatient()) {
            return null;
        }

        $patientId = $user->patient->id;

        // جلب عدد الأسئلة في المستوى
        $questionCount = $this->questions()->count();

        // جلب عدد الأسئلة التي تم التقدم فيها
        $progressCount = $this->progress()->where('patient_id', $patientId)->distinct('question_id')->count();

        // الحالة: `completed` إذا تم الإجابة على جميع الأسئلة
        if ($progressCount == $questionCount) {
            return 'completed';
        }

        // الحالة: `in_progress` إذا تم الإجابة على بعض الأسئلة
        if ($progressCount > 0) {
            return 'in_progress';
        }

        // تحديد المستوى الأول ديناميكيًا
        $firstLevel = Level::where('game_id', $this->game_id)->orderBy('number', 'asc')->first();

        if ($this->id == $firstLevel->id) {
            return 'unlocked';
        }

        // جلب المستوى السابق
        $previousLevel = Level::where('game_id', $this->game_id)
            ->where('number', '<', $this->number)
            ->orderBy('number', 'desc')
            ->first();

        // التحقق من حالة المستوى السابق
        if ($previousLevel) {
            $previousStatus = $previousLevel->getChildLevelStatus();

            if ($previousStatus == 'completed') {
                return 'unlocked';
            }
        }

        // إذا لم يتحقق أي شرط، فالمستوى مغلق `locked`
        return 'locked';
    }
}
