<?php

namespace App\Http\Services\Health;

use App\Http\Permissions\Health\InsulinDosePermission;
use App\Models\Health\InsulinDose;
use App\Services\FilterService;
use App\Services\MessageService;

class InsulinDoseService
{
    public function index($data)
    {
        $query = InsulinDose::query()->with(['patient.user']);

        $searchFields = ['insulin_type', 'injection_site'];
        $numericFields = ['dose_units'];
        $dateFields = ['taken_date'];
        $exactMatchFields = ['patient_id', 'taken_time'];

        $query = InsulinDosePermission::index($query);

        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields
        );
    }

    public function show($id)
    {
        $insulinDose = InsulinDose::find($id);

        if (!$insulinDose) {
            MessageService::abort(404, 'جرعة الأنسولين غير موجودة');
        }

        InsulinDosePermission::show($insulinDose);

        return $insulinDose;
    }

    public function create($data)
    {
        $data = InsulinDosePermission::create($data);
        return InsulinDose::create($data);
    }

    public function update($insulinDose, $data)
    {
        InsulinDosePermission::update($insulinDose);

        $insulinDose->update($data);

        return $insulinDose;
    }

    public function delete($insulinDose)
    {
        InsulinDosePermission::delete($insulinDose);

        $insulinDose->delete();
    }
}
