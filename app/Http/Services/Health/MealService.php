<?php

namespace App\Http\Services\Health;

use App\Http\Permissions\Health\MealPermission;
use App\Models\Health\Meal;
use App\Services\FilterService;
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
        return Meal::create($data);
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

        $meal->delete();
    }
}
