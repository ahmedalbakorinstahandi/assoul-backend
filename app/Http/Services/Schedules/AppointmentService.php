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


    // Schema::create('appointments', function (Blueprint $table) {
    //     $table->id();
    //     $table->unsignedBigInteger('patient_id');
    //     $table->foreign('patient_id')->references('id')->on('patients');
    //     $table->unsignedBigInteger('guardian_id')->nullable();
    //     $table->foreign('guardian_id')->references('id')->on('guardians');
    //     $table->unsignedBigInteger('doctor_id');
    //     $table->foreign('doctor_id')->references('id')->on('doctors');
    //     $table->string('title', 512);
    //     $table->dateTime('appointment_date');
    //     $table->enum('status', ["pending", "confirmed", "cancelled", "completed"]);
    //     $table->enum('canceled_by', ['admin', 'guardian', 'doctor'])->nullable();
    //     $table->timestamp('canceled_at')->nullable();
    //     $table->string('cancel_reason', 1020)->nullable();
    //     $table->enum('patient_status', ["emergency", "needs_follow_up", "stable"]);
    //     $table->text('notes')->nullable();
    //     $table->timestamps();
    //     $table->softDeletes();
    // });

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
            $appointment_date = $appointment->appointment_date->format('Y-m-d H:i');
            $title = "اقتراح موعد جديد";
            $message = 'تم اقتراح موعد جديد من الدكتور ' . $appointment->doctor->user->first_name . ' ' . $appointment->doctor->user->last_name . ' بتاريخ ' . $appointment_date;
        } elseif ($user->isGuardian()) {
            // doctor:notification
            $user_id = $appointment->doctor->user_id;
            $topic = 'user-' . $user_id;
            $appointment_date = $appointment->appointment_date->format('Y-m-d H:i');
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
