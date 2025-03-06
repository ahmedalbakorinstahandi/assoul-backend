<?php

namespace App\Http\Resources\Games;

use App\Http\Resources\Users\PatientResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientAnswerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'custom_answer' => $this->custom_answer,
            'patient_id' => $this->patient_id,
            'question_id' => $this->question_id,
            'answer_id' => $this->answer_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'question' => new QuestionResource($this->whenLoaded('question')),
            'answer' => new AnswerResource($this->whenLoaded('answer')),
        ];
    }
}
