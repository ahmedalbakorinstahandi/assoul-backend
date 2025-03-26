<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Patients\InstructionResource;
use App\Http\Resources\Patients\MedicalRecordResource;
use App\Http\Resources\Patients\PatientNoteResource;
use App\Http\Resources\Schedules\AppointmentResource;
use App\Models\Patient\DoctorPatient;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isDoctor = false;
        $doctorIsFollowing = false;

        if (Auth::check()) {
            $user = User::auth();

            if ($user->isDoctor()) {
                $isDoctor = true;
                $doctorPatient =   DoctorPatient::where('doctor_id', $user->doctor->id)
                    ->where('patient_id', $this->id)->first();

                if ($doctorPatient) {
                    $doctorIsFollowing = true;
                }
            }
        }


        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'height' => $this->height,
            'weight' => $this->weight,
            'insulin_doses' => $this->insulin_doses,
            'points' => $this->points,
            'diabetes_diagnosis_age' => $this->diabetes_diagnosis_age,
            'is_followed' => $this->when($isDoctor, $doctorIsFollowing),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user' => new UserResource($this->whenLoaded('user')),
            'guardian' => GuardianResource::collection($this->whenLoaded('guardian')),
            'medical_records' => MedicalRecordResource::collection($this->whenLoaded('medicalRecords')),
            'instructions' => InstructionResource::collection($this->whenLoaded('instructions')),
            'appointments' => AppointmentResource::collection($this->whenLoaded('appointments')),
            'notes' => PatientNoteResource::collection($this->whenLoaded('notes')),
        ];
    }
}
