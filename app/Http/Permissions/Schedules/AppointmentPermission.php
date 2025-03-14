<?php

namespace App\Http\Permissions\Schedules;

use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\MessageService;

class AppointmentPermission
{
    public static function index($query)
    {
        $user = User::auth();

        if ($user->isPatient()) {
            $query->where('patient_id', $user->patient->id);
        }

        if ($user->isGuardian()) {
            $query->where('guardian_id', $user->guardian->id);
        }

        if ($user->isDoctor()) {
            $query->where('doctor_id', $user->doctor->id);
        }

        return $query;
    }

    public static function show($appointment)
    {

        $user = User::auth();

        if ($user->isPatient() && $appointment->patient_id != $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بعرض هذا الموعد');
        }

        if ($user->isGuardian() && $appointment->guardian_id != $user->guardian->id) {
            MessageService::abort(403, 'غير مسموح لك بعرض هذا الموعد');
        }

        if ($user->isDoctor() && $appointment->doctor_id != $user->doctor->id) {
            MessageService::abort(403, 'غير مسموح لك بعرض هذا الموعد');
        }

        return $appointment;
    }

    public static function create($data)
    {

        $user = User::auth();

        if ($user->isPatient()) {
            $data['patient_id'] = $user->patient->id;
        }

        if ($user->isGuardian()) {
            $data['guardian_id'] = $user->guardian->id;
        }

        if ($user->isDoctor()) {
            $data['doctor_id'] = $user->doctor->id;
            $patient_id = $data['patient_id'];
            $patient = Patient::find($patient_id);

            $data['guardian_id'] = $patient->guardian->first()->id;
        }

        return $data;
    }

    public static function update($appointment, $data)
    {
        $user = User::auth();

        if ($user->isPatient() && $appointment->patient_id != $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بتعديل هذا الموعد');
        }

        if ($user->isGuardian() && $appointment->guardian_id != $user->guardian->id) {
            MessageService::abort(403, 'غير مسموح لك بتعديل هذا الموعد');
        }

        if ($user->isDoctor() && $appointment->doctor_id != $user->doctor->id) {
            MessageService::abort(403, 'غير مسموح لك بتعديل هذا الموعد');
        }

        return $data;
    }

    public static function delete($appointment)
    {
        $user = User::auth();

        if ($user->isPatient() && $appointment->patient_id != $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بحذف هذا الموعد');
        }

        if ($user->isGuardian() && $appointment->guardian_id != $user->guardian->id) {
            MessageService::abort(403, 'غير مسموح لك بحذف هذا الموعد');
        }

        if ($user->isDoctor() && $appointment->doctor_id != $user->doctor->id) {
            MessageService::abort(403, 'غير مسموح لك بحذف هذا الموعد');
        }

        return $appointment;
    }
}
