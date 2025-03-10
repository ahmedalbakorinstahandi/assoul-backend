<?php

namespace App\Http\Services\General;

use App\Services\MessageService;
use App\Http\Permissions\General\EducationalContentPermission;
use App\Models\General\EducationalContent;
use App\Services\FilterService;

class EducationalContentService
{
    public function index($data)
    {
        $query = EducationalContent::query();

        $searchFields = ['link'];
        $numericFields = ['duration'];
        $exactMatchFields = ['is_visible'];
        $dateFields = ['created_at'];

        $query = EducationalContentPermission::index($query);

        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields
        );
    }

    public function show($id)
    {
        $content = EducationalContent::find($id);

        if (!$content) {
            MessageService::abort(404, 'المحتوى غير موجود');
        }

        EducationalContentPermission::show($content);

        return $content;
    }

    public function create($data)
    {
        $data = EducationalContentPermission::create($data);

        $educationalContent = EducationalContent::create($data);

        $educationalContent->order = $educationalContent->id;
        $educationalContent->save();

        return $educationalContent;
    }

    public function update(EducationalContent $content, $data)
    {
        EducationalContentPermission::update($content, $data);

        $content->update($data);

        return $content;
    }

    public function delete(EducationalContent $content)
    {
        EducationalContentPermission::delete($content);

        return $content->delete();
    }
}
