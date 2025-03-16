<?php

namespace App\Http\Services\Schedules;

use App\Http\Permissions\Schedules\AppointmentPermission;
use App\Models\Schedules\Appointment;
use App\Services\FilterService;
use App\Services\MessageService;

class AppointmentService
{
    public function index($data)
    {
        $query = Appointment::query()->with(['patient.user', 'guardian.user', 'doctor.user']);

        $searchFields = ['notes'];
        $numericFields = ['patient_id', 'guardian_id', 'doctor_id'];
        $exactMatchFields = ['status', 'patient_status'];
        $dateFields = ['appointment_date'];
        $inFields = ['status', 'patient_status'];

        $query = AppointmentPermission::index($query);

        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields,
        );
    }

    public function show($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            MessageService::abort(404, 'الموعد غير موجود');
        }

        AppointmentPermission::show($appointment);

        $appointment->load(['patient.user', 'guardian.user', 'doctor.user']);

        return $appointment;
    }

    public function create($data)
    {
        $data = AppointmentPermission::create($data);

        $data['status'] = 'pending';

        return Appointment::create($data);
    }

    public function update(Appointment $appointment, $data)
    {
        AppointmentPermission::update($appointment, $data);

        $appointment->update($data);

        $appointment->load(['patient.user', 'guardian.user', 'doctor.user']);

        return $appointment;
    }

    public function delete(Appointment $appointment)
    {
        AppointmentPermission::delete($appointment);

        return $appointment->delete();
    }
}
