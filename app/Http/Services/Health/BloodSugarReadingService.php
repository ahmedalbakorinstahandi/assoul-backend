<?php

namespace App\Http\Services\Health;

use App\Http\Permissions\Health\BloodSugarReadingPermission;
use App\Models\Health\BloodSugarReading;
use App\Services\FilterService;
use App\Services\MessageService;

class BloodSugarReadingService
{
    public function index($data)
    {
        $qusery = BloodSugarReading::query()->with(['patient.user']);

        $searchFields = ['measurement_type', 'unit', 'notes'];
        $numericFields = ['value'];
        $dateFields = ['measured_at'];
        $exactMatchFields = ['patient_id', 'measurement_type', 'unit'];
        $inFields = ['measurement_type'];

        $qusery = BloodSugarReadingPermission::index($qusery);

        $qusery = FilterService::applyFilters(
            $qusery,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields
        );

        return $qusery;
    }

    public function show($id)
    {
        $bloodSugarReading = BloodSugarReading::find($id);

        if (!$bloodSugarReading) {
            MessageService::abort(404, 'قراءة سكر الدم غير موجودة');
        }

        BloodSugarReadingPermission::show($bloodSugarReading);

        return $bloodSugarReading;
    }


    public function create($data)
    {

        $data = BloodSugarReadingPermission::create($data);

        $bloodSugarReading = BloodSugarReading::create($data);

        return $bloodSugarReading;
    }

    public function update(BloodSugarReading $bloodSugarReading, $data)
    {
        BloodSugarReadingPermission::update($bloodSugarReading);

        $bloodSugarReading->update($data);

        return $bloodSugarReading;
    }

    public function delete(BloodSugarReading $bloodSugarReading)
    {
        BloodSugarReadingPermission::delete($bloodSugarReading);

        return $bloodSugarReading->delete();
    }
}
