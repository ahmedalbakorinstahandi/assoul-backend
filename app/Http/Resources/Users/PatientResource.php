<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'user_id' => $this->user_id,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'height' => $this->height,
            'weight' => $this->weight,
            'insulin_doses' => $this->insulin_doses,
            'points' => $this->points,
            'diabetes_diagnosis_age' => $this->diabetes_diagnosis_age,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'user' => new UserResource($this->whenLoaded('user')),
            'guardian' => new GuardianResource($this->whenLoaded('guardian')),
        ];
    }
}
