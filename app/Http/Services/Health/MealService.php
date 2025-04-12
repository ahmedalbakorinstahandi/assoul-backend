<?php

namespace App\Http\Services\Health;

use App\Http\Permissions\Health\MealPermission;
use App\Models\Health\Meal;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\FirebaseService;
use App\Services\MessageService;

class MealService
{
    public function index($data)
    {
        $query = Meal::query()->with(['patient.user']);

        $searchFields = ['description', 'notes'];
        $exactMatchFields = ['patient_id', 'type'];
        $dateFields = ['consumed_date'];

        $query = MealPermission::index($query);

        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            [],
            $dateFields,
            $exactMatchFields
        );
    }

    public function show($id)
    {
        $meal = Meal::find($id);

        if (!$meal) {
            MessageService::abort(404, 'هذه الوجبة غير موجودة'); // ✅ استخدم `MessageService` بدلاً من `findOrFail()`
        }

        MealPermission::show($meal);

        return $meal;
    }




    public function create($data)
    {
        $data = MealPermission::create($data);

        $meal = Meal::create($data);

        $user = User::auth();
        if ($user->isPatient()) {
            $this->sendNotificationOnMealCreation($meal, $data['patient_id']);
        }

        return $meal;
    }

    public function sendNotificationOnMealCreation(Meal $meal, $patient_id)
    {
        $patient = Patient::find($patient_id);

        $guardian = $patient->guardian;

        // guardian:notification
        FirebaseService::sendToTopicAndStorage(
            'user-' . $guardian->user_id,
            [
                $guardian->user_id,
            ],
            [
                'id' => $meal->id,
                'type' => Meal::class,
            ],
            'طفلك تناول وجبة ال' . $this->translateMealType($meal->type),
            'تم تسجيل وجبة جديدة لطفلك ' . $patient->user->first_name . ' تحتوي على: ' . $meal->description,
            'info',
        );
    }

    public function update($meal, $data)
    {
        MealPermission::update($meal);

        $meal->update($data);
        return $meal;
    }

    public function delete($meal)
    {
        MealPermission::delete($meal);

        $user = User::auth();
        if ($user->isPatient()) {
            $this->sendNotificationOnMealDeletion($meal, $meal->patient_id);
        }

        return $meal->delete();
    }

    public function sendNotificationOnMealDeletion(Meal $meal, $patient_id)
    {
        $patient = Patient::find($patient_id);

        $guardian = $patient->guardian;

        // guardian:notification
        FirebaseService::sendToTopicAndStorage(
            'user-' . $guardian->user_id,
            [
                $guardian->user_id,
            ],
            [
                'id' => $meal->id,
                'type' => Meal::class,
            ],
            'تم حذف وجبة ال' . $this->translateMealType($meal->type),
            'تم حذف وجبة تحتوي على: ' . $meal->description . ' من طفلك ' . $patient->user->first_name,
            'warning',
        );
    }

    public function translateMealType($type)
    {
        switch ($type) {
            case 'breakfast':
                return 'فطور';
            case 'lunch':
                return 'غداء';
            case 'dinner':
                return 'عشاء';
            case 'snack':
                return 'وجبة خفيفة';
            default:
                return $type;
        }
    }
}
