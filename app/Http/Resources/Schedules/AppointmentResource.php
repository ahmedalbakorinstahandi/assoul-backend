<?php

namespace App\Http\Resources\Schedules;

use App\Http\Resources\Users\DoctorResource;
use App\Http\Resources\Users\GuardianResource;
use App\Http\Resources\Users\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'guardian_id' => $this->guardian_id,
            'doctor_id' => $this->doctor_id,
            'title' => $this->title,
            'appointment_date' => $this->appointment_date,
            'status' => $this->status,
            'patient_status' => $this->patient_status,
            'notes' => $this->notes,
            'canceled_by' => $this->canceled_by,
            'canceled_at' => $this->canceled_at ? $this->canceled_at->format('Y-m-d H:i:s') : null,
            'cancel_reason' => $this->cancel_reason,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'guardian' => new GuardianResource($this->whenLoaded('guardian')),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
        ];
    }
}
