<?php

namespace App\Http\Resources\Games;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'image' => $this->image,
            'points' => $this->points,
            'type' => $this->type,
            'answers_view' => $this->answers_view,
            'level_id' => $this->level_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'level' => new LevelResource($this->whenLoaded('level')),
            'answers' => AnswerResource::collection($this->whenLoaded('answers')),
            'patient_answers' => PatientAnswerResource::collection($this->whenLoaded('patientAnswers')),
            'progresses' => ProgressResource::collection($this->whenLoaded('progresses')),
        ];
    }
}
