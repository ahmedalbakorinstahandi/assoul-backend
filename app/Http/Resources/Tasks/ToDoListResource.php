<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Users\GuardianResource;
use App\Http\Resources\Users\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToDoListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'patient_id' => $this->patient_id,
            'assigned_by_id' => $this->assigned_by,
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'assigned_by' => new GuardianResource($this->whenLoaded('assignedBy')),
            'completion' => new ToDoListCompletionResource($this->whenLoaded('completion')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
