<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Services\Games\LevelService;
use App\Http\Requests\Games\Level\CreateRequest;
use App\Http\Requests\Games\Level\UpdateRequest;
use App\Http\Resources\Games\LevelResource;
use App\Http\Resources\Games\QuestionResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    protected $levelService;

    public function __construct(LevelService $levelService)
    {
        $this->levelService = $levelService;
    }

    public function index()
    {

        $levles = $this->levelService->index(request()->all());

        return response()->json(
            [
                'success' => true,
                'data' => LevelResource::collection($levles->items()),
                'meta' => ResponseService::meta($levles),
            ]
        );
    }


    public function show($id)
    {
        $level = $this->levelService->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new LevelResource($level),
            ]
        );
    }


    public function create(CreateRequest $request)
    {

        $level = $this->levelService->create($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new LevelResource($level),
                'message' => 'تم انشاء المستوى بنجاح',
            ]
        );
    }


    public function update(UpdateRequest $request, $id)
    {

        $level = $this->levelService->show($id);

        $level = $this->levelService->update($level, $request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new LevelResource($level),
                'message' => 'تم تعديل المستوى بنجاح',
            ]
        );
    }


    public function delete($id)
    {
        $level = $this->levelService->show($id);

        $this->levelService->delete($level);

        return response()->json(
            [
                'success' => true,
                'message' => 'تم حذف المستوى بنجاح',
            ]
        );
    }

    public function getNextQuestion($id)
    {
        $level = $this->levelService->show($id);

        $question = $this->levelService->getNextQuestion($level);

        return response()->json([
            'success' => true,
            'data' => new QuestionResource($question),
        ]);
    }
}
