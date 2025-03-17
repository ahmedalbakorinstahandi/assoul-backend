<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patients\Instruction\CreateRequest;
use App\Http\Requests\Patients\Instruction\UpdateRequest;
use App\Http\Resources\Patients\InstructionResource;
use App\Http\Services\Patients\InstructionService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    protected $instructionService;

    public function __construct(InstructionService $instructionService)
    {
        $this->instructionService = $instructionService;
    }

    public function index()
    {

        $instructions = $this->instructionService->index(request()->all());

        return response()->json(
            [
                'success' => true,
                'data' => InstructionResource::collection($instructions),
                'meta' => ResponseService::meta($instructions),
            ],
            200
        );
    }

    public function show($id)
    {
        $instruction = $this->instructionService->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new InstructionResource($instruction),
            ],
            200
        );
    }

    public function create(CreateRequest $request)
    {
        $instruction = $this->instructionService->create($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new InstructionResource($instruction),
                'message' => "تم إنشاء السجل بنجاح",
            ],
            200
        );
    }

    public function update(UpdateRequest $request, $id)
    {
        $instruction = $this->instructionService->show($id);


        $instruction = $this->instructionService->udpate($instruction, $request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new InstructionResource($instruction),
                'message' => "تم تعديل السجل بنجاح",
            ],
            200
        );
    }

    public function delete($id)
    {
        $instruction = $this->instructionService->show($id);


        $this->instructionService->delete($instruction);

        return response()->json(
            [
                'success' => true,
                'message' => "تم حذف السجل بنجاح",
            ],
            200
        );
    }
}
