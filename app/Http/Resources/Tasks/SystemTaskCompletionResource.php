<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Users\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemTaskCompletionResource extends JsonResource
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
            'task_id' => $this->task_id,
            'patient_id' => $this->patient_id,
            'completed_at' => $this->completed_at,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'task' => new SystemTaskResource($this->whenLoaded('task')),
        ];
    }
}
