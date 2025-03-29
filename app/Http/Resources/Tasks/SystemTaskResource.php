<?php

namespace App\Http\Resources\Tasks;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemTaskResource extends JsonResource
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
            'title' => $this->title,
            'color' => $this->color,
            'points' => $this->points,
            'image' => $this->image,
            'unique_key' => $this->unique_key,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'system_task_completion' => $this->whenLoaded(
                'systemTaskCompletion',
                fn() => new SystemTaskCompletionResource($this->getSystemTaskCompletion())
            ),
        ];
    }
}
