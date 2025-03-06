<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Http\Requests\Games\Game\CreateRequest;
use App\Http\Requests\Games\Game\UpdateRequest;
use App\Http\Resources\Games\GameResource;
use App\Http\Services\Games\GameService;
use App\Services\ResponseService;
class GameController extends Controller
{
    protected $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function index()
    {
        $games = $this->gameService->index(request()->all());

        return response()->json(
            [
                'success' => true,
                'data' => GameResource::collection($games->items()),
                'meta' => ResponseService::meta($games)
            ]
        );
    }

    public function show($id)
    {
        $game = $this->gameService->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new GameResource($game)
            ]
        );
    }

    public function create(CreateRequest $request)
    {
        $game = $this->gameService->create($request->all());

        return response()->json(
            [
                'success' => true,
                'data' => new GameResource($game),
                'message' => 'تم إنشاء اللعبة بنجاح'
            ]
        );
    }

    public function update(UpdateRequest $request, $id)
    {
        $game = $this->gameService->show($id);

        $game = $this->gameService->update($game, $request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new GameResource($game),
                'message' => 'تم تحديث اللعبة بنجاح'
            ]
        );
    }

    public function delete($id)
    {
        $game = $this->gameService->show($id);

        $this->gameService->delete($game);

        return response()->json(
            [
                'success' => true,
                'message' => 'تم حذف اللعبة بنجاح'
            ]
        );
    }
}
