<?php

namespace App\Http\Services\Health;

use App\Http\Permissions\Health\PhysicalActivityPermission;
use App\Models\Health\PhysicalActivity;
use App\Services\FilterService;
use App\Services\MessageService;

class PhysicalActivityService
{
    public function index($data)
    {
        $query = PhysicalActivity::query()->with(['patient.user']);

        $searchFields = ['description', 'notes'];
        $numericFields = ['duration'];
        $dateFields = ['activity_date'];
        $exactMatchFields = ['patient_id', 'intensity', 'activity_time'];

        $query = PhysicalActivityPermission::index($query);

        return FilterService::applyFilters($query, $data, $searchFields, $numericFields, $dateFields, $exactMatchFields);
    }

    public function show($id)
    {
        $activity = PhysicalActivity::find($id);

        if (!$activity) {
            MessageService::abort(404, 'هذا السجل غير موجود');
        }

        PhysicalActivityPermission::show($activity);

        return $activity;
    }

    public function create($data)
    {
        $data = PhysicalActivityPermission::create($data);

        return PhysicalActivity::create($data);
    }

    public function update($activity, $data)
    {
        PhysicalActivityPermission::update($activity);

        $activity->update($data);
        return $activity;
    }

    public function delete($activity)
    {
        PhysicalActivityPermission::delete($activity);

        $activity->delete();
    }
}
