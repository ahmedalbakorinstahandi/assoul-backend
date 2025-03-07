<?php

namespace App\Http\Resources\Games;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'text' => $this->question->type == 'LetterArrangement' ? str_shuffle($this->text) : $this->text,
            'image' => $this->image,
            // 'is_correct' => $this->is_correct,
            'question_id' => $this->question_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'question' => new QuestionResource($this->whenLoaded('question')),
            'patient_answers' => PatientAnswerResource::collection($this->whenLoaded('patientAnswers')),
            'progresses' => ProgressResource::collection($this->whenLoaded('progresses')),
        ];
    }
}
