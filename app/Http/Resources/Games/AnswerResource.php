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
            'text' => $this->question->type == 'LetterArrangement' ? preg_split('//u', $this->mb_str_shuffle($this->text), -1, PREG_SPLIT_NO_EMPTY) :  $this->text,




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

    private function mb_str_shuffle($string)
    {
        $characters = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
        shuffle($characters);
        return implode('', $characters);
    }
}
