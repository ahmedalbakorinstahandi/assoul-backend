<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Notifications\NotificationResource;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // ToDo: Check if the user is a guardian and the patient is one of their children
        $condition = true;

        // if (Auth::check()) {
        //     $user = User::auth();

        //     if ($user->isGuardian() && $this->isPatient() && optional($user->guardian)->children) {
        //         $childrenIds = $user->guardian->children->pluck('id')->toArray();
        //         if (in_array($this->id, $childrenIds)) {
        //             $condition = true;
        //         }
        //     }

        //     if ($user->isAdmin() && $this->isPatient()) {
        //         $condition = true;
        //     }
        // }



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
            'otp' => $this->when($condition, $this->otp),
            'otp_expide_at' => $this->when($condition, $this->otp_expide_at),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'guardians' => new GuardianResource($this->whenLoaded('guardians')),
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'notifications' => NotificationResource::collection($this->whenLoaded('notifications')),
        ];
    }
}
