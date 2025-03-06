<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\Answer\CreateRequest;
use App\Http\Requests\Games\Answer\UpdateRequest;
use App\Http\Resources\Games\AnswerResource;
use App\Http\Services\Games\AnswerService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    protected $answerService;

    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }

    public function index()
    {
        $answers = $this->answerService->index(request()->all());

        return response()->json([
            'success' => true,
            'data' => AnswerResource::collection($answers->items()),
            'meta' => ResponseService::meta($answers),
        ]);
    }

    public function show($id)
    {
        $answer = $this->answerService->show($id);

        return response()->json([
            'success' => true,
            'data' => new AnswerResource($answer),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $answer = $this->answerService->create($request->all());

        return response()->json([
            'success' => true,
            'data' => new AnswerResource($answer),
            'message' => 'تم إنشاء الإجابة بنجاح',
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $answer = $this->answerService->show($id);

        $answer = $this->answerService->update($answer, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new AnswerResource($answer),
            'message' => 'تم تحديث الإجابة بنجاح',
        ]);
    }

    public function delete($id)
    {
        $answer = $this->answerService->show($id);

        $this->answerService->delete($answer);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الإجابة بنجاح',
        ]);
    }
}
