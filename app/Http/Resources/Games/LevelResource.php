<?php

namespace App\Http\Resources\Games;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'number' => $this->number,
            'status' => $this->status,
            'child_status' => $this->getChildLevelStatus(),
            'question_count' => $this->questions()->count(),
            'game_id' => $this->game_id,
            'can_publish' => $this->canPublish(),
            'game' => new GameResource($this->whenLoaded('game')),
            'questions' => QuestionResource::collection($this->whenLoaded('questions')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'progresses' => ProgressResource::collection($this->whenLoaded('progresses')),
        ];
    }
}
