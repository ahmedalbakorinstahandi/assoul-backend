<?php

namespace App\Http\Resources\Games;

use App\Http\Resources\Users\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'game_id' => $this->game_id,
            'level_id' => $this->level_id,
            'question_id' => $this->question_id,
            'points' => $this->points,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'game' => new GameResource($this->whenLoaded('game')),
            'level' => new LevelResource($this->whenLoaded('level')),
            'question' => new QuestionResource($this->whenLoaded('question')),
        ];
    }
}
