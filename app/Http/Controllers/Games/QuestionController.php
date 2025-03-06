<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\Question\AnswerQuestionRequest;
use App\Http\Requests\Games\Question\CreateRequest;
use App\Http\Requests\Games\Question\NextQuestionRequest;
use App\Http\Requests\Games\Question\UpdateRequest;
use App\Http\Resources\Games\QuestionResource;
use App\Http\Services\Games\QuestionService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function index()
    {
        $questions = $this->questionService->index(request()->all());

        return response()->json([
            'success' => true,
            'data' => QuestionResource::collection($questions->items()),
            'meta' => ResponseService::meta($questions),
        ]);
    }

    public function show($id)
    {
        $question = $this->questionService->show($id);

        return response()->json([
            'success' => true,
            'data' => new QuestionResource($question),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $question = $this->questionService->create($request->all());

        return response()->json([
            'success' => true,
            'data' => new QuestionResource($question),
            'message' => 'تم إنشاء السؤال بنجاح',
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $question = $this->questionService->show($id);

        $question = $this->questionService->update($question, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new QuestionResource($question),
            'message' => 'تم تحديث السؤال بنجاح',
        ]);
    }

    public function delete($id)
    {
        $question = $this->questionService->show($id);

        $this->questionService->delete($question);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف السؤال بنجاح',
        ]);
    }


    public function getNextQuestion(NextQuestionRequest $request)
    {
        $question = $this->questionService->getNextQuestion($request->validated());

        return response()->json([
            'success' => true,
            'data' => $question ? new QuestionResource($question) : null,
        ]);
    }

    public function answerQuestion(AnswerQuestionRequest $request, $id)
    {
        $question = $this->questionService->show($id);

        $answer_is_correct = $this->questionService->answerQuestion($question, $request->validated());

        $next_question = $this->questionService->getNextQuestion(['level_id' => $question->level_id]);

        return response()->json([
            'success' => true,
            'data' => [
                "answer_is_correct" => $answer_is_correct,
                'next_question' =>  $next_question ? new QuestionResource($next_question) : null,
            ],
            'message' => $answer_is_correct ? 'إجابة صحيحة' : 'إجابة خاطئة',
        ]);
    }
}
