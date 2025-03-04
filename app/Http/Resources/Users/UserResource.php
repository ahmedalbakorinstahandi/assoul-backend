<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Notifications\NotificationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role,
            'phone' => $this->phone,
            'verified' => $this->verified,
            'avatar' => $this->avatar,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'guardians' => new GuardianResource($this->whenLoaded('guardians')),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'notifications' => NotificationResource::collection($this->whenLoaded('notifications')),
        ];
    }
}
