<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\EducationalContent\CreateRequest;
use App\Http\Requests\General\EducationalContent\UpdateRequest;
use App\Http\Resources\General\EducationalContentResource;
use App\Http\Services\General\EducationalContentService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class EducationalContentController extends Controller
{
    protected $educationalContentService;

    public function __construct(EducationalContentService $educationalContentService)
    {
        $this->educationalContentService = $educationalContentService;
    }

    public function index(Request $request)
    {
        $contents = $this->educationalContentService->index($request->all());

        return response()->json([
            'success' => true,
            'data' => EducationalContentResource::collection($contents->items()),
            'meta' => ResponseService::meta($contents),
        ]);
    }

    public function show($id)
    {
        $content = $this->educationalContentService->show($id);

        return response()->json([
            'success' => true,
            'data' => new EducationalContentResource($content),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $content = $this->educationalContentService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new EducationalContentResource($content),
            'message' => 'تم إنشاء المحتوى التعليمي بنجاح',
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $content = $this->educationalContentService->show($id);

        $content = $this->educationalContentService->update($content, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new EducationalContentResource($content),
            'message' => 'تم تحديث المحتوى التعليمي بنجاح',
        ]);
    }

    public function delete($id)
    {
        $content = $this->educationalContentService->show($id);

        $this->educationalContentService->delete($content);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المحتوى التعليمي بنجاح',
        ]);
    }
}