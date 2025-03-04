<?php

namespace App\Http\Resources\Health;

use App\Http\Resources\Users\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InsulinDoseResource extends JsonResource
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
            'taken_date' => $this->taken_date,
            'taken_time' => $this->taken_time,
            'insulin_type' => $this->insulin_type,
            'dose_units' => $this->dose_units,
            'injection_site' => $this->injection_site,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'patient' => new PatientResource($this->whenLoaded('patient')),
        ];
    }
}
