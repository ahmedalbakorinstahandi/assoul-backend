<?php

namespace App\Http\Resources\Health;

use App\Http\Resources\Users\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BloodSugarReadingResource extends JsonResource
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
            'measurement_type' => $this->measurement_type,
            'value' => $this->value,
            'unit' => $this->unit,
            'notes' => $this->notes,
            'measured_at' => $this->measured_at,
            'measurementable' => [
                'id' => $this->measurementable_id,
                'type' => $this->measurementable_type,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'patient' => new PatientResource($this->whenLoaded('patient')),
        ];
    }
}
