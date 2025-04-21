<?php

namespace App\Http\Services\Schedules;

use App\Http\Permissions\Schedules\AppointmentPermission;
use App\Models\Schedules\Appointment;
use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\FirebaseService;
use App\Services\MessageService;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AppointmentService
{
    public function index($data)
    {
        $query = Appointment::query()->with(['patient.user', 'guardian.user', 'doctor.user']);

        $searchFields = ['notes'];
        $numericFields = ['patient_id', 'guardian_id', 'doctor_id'];
        $exactMatchFields = ['status', 'patient_status', 'patient_id', 'guardian_id', 'doctor_id'];
        $dateFields = ['appointment_date'];
        $inFields = ['status', 'patient_status'];

        $query = AppointmentPermission::index($query);

        $query = FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields,
            false,
        );


        // Clone the query for each count to avoid interference
        $confirmed_count = (clone $query)->where('status', 'confirmed')->count();
        $completed_count = (clone $query)->where('status', 'completed')->count();
        $cancelled_count = (clone $query)->where('status', 'cancelled')->count();
        $pending_count = (clone $query)->where('status', 'pending')->count();
        $needs_follow_up_count = (clone $query)->where('patient_status', 'needs_follow_up')->count();
        $emergency_count = (clone $query)->where('patient_status', 'emergency')->count();
        $stable_count = (clone $query)->where('patient_status', 'stable')->count();

        $all_count = (clone $query)->count();

        $appointments = $query->latest()->paginate($data['limit'] ?? 20);


        return [
            'data' => $appointments,
            'info' => [
                'confirmed_count' => $confirmed_count,
                'completed_count' => $completed_count,
                'cancelled_count' => $cancelled_count,
                'pending_count' => $pending_count,
                'needs_follow_up_count' => $needs_follow_up_count,
                'emergency_count' => $emergency_count,
                'stable_count' => $stable_count,
                'all_count' => $all_count,
            ],
        ];
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



        $appointment = Appointment::create($data);

        $this->sendNotification($appointment);

        return $appointment->load(['patient.user', 'guardian.user', 'doctor.user']);
    }


    // send notification on create appointment
    public function sendNotification($appointment)
    {
        $user = User::auth();

        if ($user->isDoctor()) {
            // guardian:notification
            $patient = Patient::find($appointment->patient_id);
            $guardian = ChildrenGuardian::where('patient_id', $patient->id)->first()->guardian;
            $user_id = $guardian->user_id;
            $topic = 'user-' . $user_id;
            $appointment_date = $appointment->appointment_date->format('Y-m-d');
            $title = "اقتراح موعد جديد";
            $message = 'تم اقتراح موعد جديد من الدكتور ' . $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name . ' بتاريخ ' . $appointment_date;
        } elseif ($user->isGuardian()) {
            // doctor:notification
            $user_id = $appointment->doctor->user_id;
            $topic = 'user-' . $user_id;
            $appointment_date = $appointment->appointment_date->format('Y-m-d');
            $title = "طلب حجز موعد جديد";
            $message = 'عندك طلب حجز موعد جديد للمريض ' . $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name . ' بتاريخ ' . $appointment_date;
        }

        FirebaseService::sendToTopicAndStorage(
            $topic,
            [$user_id],
            [
                'id' => $appointment->id,
                'type' => Appointment::class,
            ],
            $title,
            $message,
            'info',
        );
    }

    public function update(Appointment $appointment, $data)
    {
        AppointmentPermission::update($appointment, $data);

        if ($data['status'] != 'pending') {
            $this->updateStatusNotfication($appointment, $data['status']);
        }

        $appointment->update($data);

        if ($data['status'] == 'cancelled') {
            $appointment->cancel_reason = $data['cancel_reason'];
            $appointment->canceled_at = now();
            $appointment->canceled_by = User::auth()->role;
            $appointment->save();
        }


        $appointment->load(['patient.user', 'guardian.user', 'doctor.user']);

        return $appointment;
    }


    public function updateStatusNotfication($appointment, $status)
    {
        $user = User::auth();

        if ($user->isDoctor()) {
            // guardian:notification
            $patient = Patient::find($appointment->patient_id);
            $guardian = ChildrenGuardian::where('patient_id', $patient->id)->first()->guardian;
            $user_id = $guardian->user_id;
            $topic = 'user-' . $user_id;
            $appointment_date = $appointment->appointment_date->format('Y-m-d');

            if ($status == 'cancelled') {
                if ($appointment->$status == 'pending') {
                    $title = "رفض الطلب";
                    $message = 'تم رفض طلب الموعد من الدكتور ' . $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name . ' بتاريخ ' . $appointment_date;
                } elseif ($appointment->$status == 'confirmed') {
                    $title = "إلغاء الموعد";
                    $message = 'تم إلغاء الموعد من الدكتور ' . $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name . ' بتاريخ ' . $appointment_date;
                }
            } elseif ($status == 'confirmed') {
                $title = "تأكيد الموعد";
                $message = 'تم تأكيد الموعد من الدكتور ' . $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name . ' بتاريخ ' . $appointment_date;
            } elseif ($status == 'completed') {
                $title = "إكمال الموعد";
                $message = 'تم إكمال الموعد من الدكتور ' . $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name . ' بتاريخ ' . $appointment_date;
            } elseif ($status == 'pending') {
                $title = "تحديث حالة الموعد";
                $message = 'تم تحديث حالة الموعد إلى معلق من الدكتور ' . $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name . ' بتاريخ ' . $appointment_date;
            }
        } elseif ($user->isGuardian()) {
            // doctor:notification
            $user_id = $appointment->doctor->user_id;
            $topic = 'user-' . $user_id;
            $appointment_date = $appointment->appointment_date->format('Y-m-d');

            if ($status == 'cancelled') {
                $title = "إلغاء الموعد";
                $message = 'تم إلغاء الموعد من ولي الأمر للمريض ' . $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name . ' بتاريخ ' . $appointment_date;
            } elseif ($status == 'confirmed') {
                $title = "تأكيد الموعد";
                $message = 'تم تأكيد الموعد من ولي الأمر للمريض ' . $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name . ' بتاريخ ' . $appointment_date;
            } elseif ($status == 'completed') {
                $title = "إكمال الموعد";
                $message = 'تم إكمال الموعد من ولي الأمر للمريض ' . $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name . ' بتاريخ ' . $appointment_date;
            } elseif ($status == 'pending') {
                $title = "تحديث حالة الموعد";
                $message = 'تم تحديث حالة الموعد إلى معلق من ولي الأمر للمريض ' . $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name . ' بتاريخ ' . $appointment_date;
            }
        }

        FirebaseService::sendToTopicAndStorage(
            $topic,
            [$user_id],
            [
                'id' => $appointment->id,
                'type' => Appointment::class,
                'status' => 1,
                'status_text' => Appointment::getStatusText($status),
                'status_type' => Appointment::getStatusType($status),
                'status_color' => Appointment::getStatusColor($status),
                'status_icon' => Appointment::getStatusIcon($status),
            ],
            $title,
            $message,
            'info',
        );
    }

    public function delete(Appointment $appointment)
    {
        AppointmentPermission::delete($appointment);

        return $appointment->delete();
    }

    public function cancel(Appointment $appointment, $data)
    {
        $appointment->cancel_reason = $data['cancel_reason'];
        $appointment->canceled_at = now();
        $appointment->canceled_by = User::auth()->role;
        $appointment->status = 'cancelled';
        $appointment->save();

        // TODO:: SEND NOTIFICATIONS

        $appointment->load(['patient.user', 'guardian.user', 'doctor.user']);

        return $appointment;
    }
}
